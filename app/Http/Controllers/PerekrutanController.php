<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PelamarExport;
use App\Mail\DiterimaEmail;
use App\Mail\UndanganEmail;
use App\Mail\ApplyEmail;
use App\Mail\TolakEmail;
use App\Mail\BataltolakEmail;
use App\Mail\TolakUndanganEmail;
use App\Mail\ConfirmUndanganEmail;
use App\Mail\TdkLulusEmail;
use App\Notifications\Notifikasi;
use App\Lowongan;
use App\Mahasiswa;
use App\Perusahaan;
use App\Rekrut;
use App\Skill;
use App\User;
use Auth;
use DB;
use Mail;
use Notification;
use Session;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

class PerekrutanController extends Controller
{
    public function apply($id)
    {
        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->where('lowongan_id', $id)->first();
        if(empty($lowongan)) return abort(404);
        
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                            ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                            ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email)->first();
        if(empty($lowongan)) return abort(404);

        if($mahasiswa->mahasiswa_status!='mencari') {
            Session::flash('error', 'Anda sudah mendapatkan tempat magang');
            return redirect()->back();
        }

        $rekrut = Rekrut::where('rekrut_mahasiswa_id', $mahasiswa->mahasiswa_id)
                        ->where('rekrut_lowongan_id', $lowongan->lowongan_id)->get();
        if(count($rekrut)) {
            Session::flash('error', 'Anda sudah melamar pada lowongan ini');
            return redirect()->back();
        }

        date_default_timezone_set('Asia/Jakarta');

        $rekrut = new Rekrut;
        $rekrut->rekrut_lowongan_id  = $lowongan->lowongan_id;
        $rekrut->rekrut_mahasiswa_id = $mahasiswa->mahasiswa_id;
        $rekrut->rekrut_waktu_melamar= date("Y-m-d H:i:s");
        $rekrut->rekrut_status       = 'melamar';
        $simpanrekrut = $rekrut->save();
                            
        if($simpanrekrut)
        {
            $receiver = User::where('user_email', $lowongan->perusahaan_user_email)->first();
            Notification::send($receiver, new Notifikasi(
                'Lamaran baru dari <b>'.$mahasiswa->univ_nama.'</b> pada lowongan '.$lowongan->lowongan_judul, 
                route('perekrutan.pelamar').'?filter_status=melamar'
                ));

            Mail::to($lowongan->perusahaan_user_email)->send(new ApplyEmail($lowongan, $mahasiswa));

            Session::flash('success', 'Melamar lowongan berhasil, mohon tunggu perusahaan mengirim undangan test kepada anda.');
            return redirect()->back();
        } else {
            Session::flash('error', 'Melamar lowongan gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }

    public function pelamar(Request $request)
    {
        $filter = new \stdClass();
        
        if(!empty($request->filter_lowongan)) $filter->lowongan = $request->filter_lowongan;
        else $filter->lowongan = "";
        
        if(!empty($request->filter_status)) $filter->status = $request->filter_status;
        else $filter->status = "";

        // // DB::enableQueryLog();
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        // // dd(DB::getQueryLog());
        if(empty($perusahaan)) return abort(404);
        
        $rekruts = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('lowongan_perusahaan_id', "=", $perusahaan->perusahaan_id);
                        
        if(!empty($request->filter_lowongan)) {
            $rekruts = $rekruts->where('rekrut_lowongan_id', "=", $request->filter_lowongan);
            $lowongan = Lowongan::where('lowongan_id', $request->filter_lowongan)->first();
            $filter->lowongan_judul = $lowongan->lowongan_judul;
        }     

        if(!empty($request->filter_status)) {
            $rekruts = $rekruts->where('rekrut_status', "=", $request->filter_status);
        }
        
        $rekruts = $rekruts->get();

    	return view('lowongan.pelamar', [
            'perusahaan' => $perusahaan,
            'filter' => $filter,
            'rekruts' => $rekruts,
        ]);
    }

    public function pelamardownload(Request $request)
    {
        // // DB::enableQueryLog();
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        // // dd(DB::getQueryLog());
        if(empty($perusahaan)) return abort(404);

        $request->request->add(['auth_user_email' => Auth::user()->user_email]);
		return Excel::download(new PelamarExport($request), 'pelamar-'.date("Y-m-d_His").'.xlsx');
    }
    
    public function lamaranlist(Request $request)
    {
        $filter = new \stdClass();
        
        if(!empty($request->filter_status)) $filter->status = $request->filter_status;
        else $filter->status = "";

        // DB::enableQueryLog();
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                                ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        // dd(DB::getQueryLog());
        if(empty($mahasiswa)) abort(404);

        $rekruts = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id);
        
        if(!empty($request->filter_status)) {
            $rekruts = $rekruts->where('rekrut_status', "=", $request->filter_status);
        }
        
        $rekruts = $rekruts->get();

    	return view('lowongan.list_lamaran', [
            'filter' => $filter,
            'rekruts' => $rekruts,
        ]);
    }
    
    public function lamaranlist_dospem($mahasiswa_id, Request $request)
    {
        $filter = new \stdClass();
        
        if(!empty($request->filter_status)) $filter->status = $request->filter_status;
        else $filter->status = "";

        // DB::enableQueryLog();
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                                ->where('mahasiswa_id', $mahasiswa_id )->first();
        // dd(DB::getQueryLog());
        if(empty($mahasiswa)) abort(404);

        $skills = Skill::where('skill_mahasiswa_id', $mahasiswa_id)
                        ->get();

        $rekruts = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id);
        
        if(!empty($request->filter_status)) {
            $rekruts = $rekruts->where('rekrut_status', "=", $request->filter_status);
        }
        
        $rekruts = $rekruts->get();

    	return view('dospem.list_lamaran', [
            'filter' => $filter,
            'rekruts' => $rekruts,
            'mahasiswa' => $mahasiswa,
            'skills' => $skills,
        ]);
    }
    
    public function detailpelamar($id)
    {

                        // DB::enableQueryLog();
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
                        // dd(DB::getQueryLog());
        if(empty($rekrut)) return abort(404);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

        $rekrut->lowongan_requirement = htmlspecialchars_decode($rekrut->lowongan_requirement);
        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);
        $rekrut->rekrut_undangan_desc = htmlspecialchars_decode($rekrut->rekrut_undangan_desc);

    	return view('lowongan.detail_pelamar', [
            'rekrut' => $rekrut,
            'skills' => $skills
        ]);
    }
    
    public function detailpelamar_dospem($id)
    {

                        // DB::enableQueryLog();
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('rekrut_id', $id)->first();
                        // dd(DB::getQueryLog());
        if(empty($rekrut)) return abort(404);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

        $rekrut->lowongan_requirement = htmlspecialchars_decode($rekrut->lowongan_requirement);
        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);
        $rekrut->rekrut_undangan_desc = htmlspecialchars_decode($rekrut->rekrut_undangan_desc);

    	return view('dospem.detail_pelamar', [
            'rekrut' => $rekrut,
            'skills' => $skills
        ]);
    }
    
    public function tolak($id)
    {
        if(empty($id)) abort(404);

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            Rekrut::where('rekrut_id',$id)
                ->update([
                    'rekrut_status' => 'melamartlk',
                ]);
                
            Mail::to($rekrut->mahasiswa_user_email)->send(new TolakEmail($rekrut));
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->mahasiswa_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            'Mohon maaf, <b>'.$rekrut->perusahaan_nama.'</b> menolak lamaran anda pada lowongan '.$rekrut->lowongan_judul, 
            route('perekrutan.detaillamaran', ['id' => $rekrut->rekrut_id])
        ));

        Session::flash('success', 'Tolak lamaran berhasil.');
        return redirect()->back();
    }
    
    
    public function bataltolak($id)
    {
        if(empty($id)) abort(404);

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            Rekrut::where('rekrut_id',$id)
                ->update([
                    'rekrut_status' => 'melamar',
                ]);
                
            Mail::to($rekrut->mahasiswa_user_email)->send(new BataltolakEmail($rekrut));
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->mahasiswa_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            '<b>'.$rekrut->perusahaan_nama.'</b> membatalkan penolakan lamaran anda pada lowongan '.$rekrut->lowongan_judul.', semoga beruntung!', 
            route('perekrutan.detaillamaran', ['id' => $rekrut->rekrut_id])
        ));

        Session::flash('success', 'Batal tolak lamaran berhasil.');
        return redirect()->back();
    }
    
    
    public function undang(Request $request)
    {
        if(empty($request->rekrut_id)) abort(404);

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $request->rekrut_id)->first();
        if(empty($rekrut)) return abort(404);

        $rules = [
            'undangan_desc'     => 'required',
            'undangan_tanggal'  => 'required',
            'undangan_waktu'    => 'required',
            'undangan_alamat'   => 'required',
        ];
 
        $messages = [
            'undangan_desc.required'    => 'Masukan detail undangan',
            'undangan_tanggal.required' => 'Pilih tanggal undangan',
            'undangan_waktu.required'   => 'Pilih waktu undangan',
            'undangan_alamat.required'  => 'Masukan alamat undangan',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $request->rekrut_id)
                ->update([
                    'rekrut_status'         => 'diundang',
                    'rekrut_undangan_desc'  => htmlspecialchars($request->undangan_desc),
                    'rekrut_undangan_waktu' => $request->undangan_tanggal.' '.$request->undangan_waktu,
                    'rekrut_undangan_alamat'=> $request->undangan_alamat,
                    'rekrut_waktu_diundang' => date("Y-m-d H:i:s"),
                ]);
                
            Mail::to($rekrut->mahasiswa_user_email)->send(new UndanganEmail($rekrut, $request));

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->mahasiswa_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            '<b>'.$rekrut->perusahaan_nama.'</b> mengundang anda untuk test pada '.date('d F Y',strtotime($request->undangan_tanggal)).' pukul '.$request->undangan_waktu, 
            route('perekrutan.detaillamaran', ['id' => $request->rekrut_id])
        ));

        Session::flash('success', 'Undangan test berhasil dikirim, menunggu mahasiswa konfirmasi kehadiran test.');
        return redirect()->back();
    }
    
    public function kirimulangundangan($rekrut_id)
    {
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $rekrut_id)->first();
        if(empty($rekrut)) return abort(404);

        $request = new \stdClass();
        $request->undangan_tanggal  = $rekrut->rekrut_undangan_waktu;
        $request->undangan_waktu    = $rekrut->rekrut_undangan_waktu;
        $request->undangan_alamat   = $rekrut->rekrut_undangan_alamat;
        $request->undangan_desc     = htmlspecialchars_decode($rekrut->rekrut_undangan_alamat);

        Mail::to($rekrut->mahasiswa_user_email)->send(new UndanganEmail($rekrut, $request));
        
        Session::flash('success', 'Undangan test berhasil dikirim, menunggu mahasiswa konfirmasi kehadiran test.');
        return redirect()->back();
    }
    
    public function tolakundangan(Request $request)
    {
        if(empty($request->rekrut_id)) abort(404);

        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $request->rekrut_id)->first();
        if(empty($rekrut)) return abort(404);

        $rules = [
            'alasan_penolakan'     => 'required',
        ];
 
        $messages = [
            'alasan_penolakan.required'    => 'Masukan alasan penolakan',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $request->rekrut_id)
                ->update([
                    'rekrut_status'              => 'tlkundang',
                    'rekrut_tolakundangan_reason'=> $request->alasan_penolakan,
                    'rekrut_waktu_tolakundangan' => date("Y-m-d H:i:s"),
                ]);

                Mail::to($rekrut->perusahaan_user_email)->send(new TolakUndanganEmail($rekrut, $request->alasan_penolakan));
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->perusahaan_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            '<b>'.$rekrut->mahasiswa_nama.'</b> menolak undangan test anda dengan alasan: '.$request->alasan_penolakan, 
            route('perekrutan.detailpelamar', ['id' => $request->rekrut_id])
        ));
        
        Session::flash('success', 'Penolakan undangan berhasil, mohon hubungi perusahaan untuk penawaran undangan kembali.');
        return redirect()->back();
    }
    
    public function detaillamaran($id)
    {
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        $rekrut->lowongan_requirement = htmlspecialchars_decode($rekrut->lowongan_requirement);
        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);
        $rekrut->rekrut_undangan_desc = htmlspecialchars_decode($rekrut->rekrut_undangan_desc);

    	return view('lowongan.detail_lamaran', [
            'rekrut' => $rekrut
        ]);
    }
    
    public function confirmundangan($id)
    {
        if(empty($id)) abort(404);
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $id)
                ->update([
                    'rekrut_status'                 => 'cnfrmtest',
                    'rekrut_waktu_konfirmundangan'  => date("Y-m-d H:i:s"),
                ]);

            Mail::to($rekrut->perusahaan_user_email)->send(new ConfirmUndanganEmail($rekrut));
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub ');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->perusahaan_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            '<b>'.$rekrut->mahasiswa_nama.'</b> mengkonfirrmasi undangan test anda pada lowongan '.$rekrut->lowongan_judul, 
            route('perekrutan.detailpelamar', ['id' => $rekrut->rekrut_id])
        ));
        
        Session::flash('success', 'Undangan berhasil dikonfirmasi, semoga sukses!');
        return redirect()->back();
    }

    public function tdklulus($id)
    {
        if(empty($id)) abort(404);
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $id)
                ->update([
                    'rekrut_status' => 'tdklulus'
                ]);

            Mail::to($rekrut->mahasiswa_user_email)->send(new TdkLulusEmail($rekrut));
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub ');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->mahasiswa_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            'Mohon maaf anda tidak lulus test pada lowongan '.$rekrut->lowongan_judul.' pada <b>'.$rekrut->perusahaan_nama.'</b>', 
            route('perekrutan.detaillamaran', ['id' => $rekrut->rekrut_id])
        ));

        Session::flash('success', 'Mahasiswa berhasil dinyatakan tidak lulus test');
        return redirect()->back();
    }

    public function lulus($id)
    {
        if(empty($id)) abort(404);
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            $sisa_kuota = $rekrut->lowongan_jlh_dibutuhkan-1;
            try
            {
                if($sisa_kuota<1)
                {
                    Lowongan::where('lowongan_id', $rekrut->lowongan_id)
                        ->update([
                            'lowongan_jlh_dibutuhkan' => $sisa_kuota,
                            'lowongan_status' => 'draft',
                        ]);
                }
                else
                {
                    Lowongan::where('lowongan_id', $rekrut->lowongan_id)
                        ->update([
                            'lowongan_jlh_dibutuhkan' => $sisa_kuota,
                        ]);
                }
            } catch (\Illuminate\Database\QueryException $e) {
                Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
                return redirect()->back();
            }

            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $id)
                ->update([
                    'rekrut_status' => 'lulus',
                    'rekrut_waktu_diterima'  => date("Y-m-d H:i:s"),
                ]);

            Rekrut::where('rekrut_id', '!=', $id)
                ->where('rekrut_mahasiswa_id', $rekrut->mahasiswa_id)
                ->update([
                    'rekrut_status' => 'magang',
                ]);

            Mahasiswa::where('mahasiswa_id', $rekrut->mahasiswa_id)
                ->update([
                    'mahasiswa_status' => 'magang',
                ]);

            Mail::to($rekrut->mahasiswa_user_email)->send(new DiterimaEmail($rekrut));

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub ');
            return redirect()->back();
        }

        $receiver = User::where('user_email', $rekrut->mahasiswa_user_email)->first();
        Notification::send($receiver, new Notifikasi(
            'Selamat! anda diterima magang pada <b>'.$rekrut->perusahaan_nama.'</b>. Semoga sukses!', 
            route('perekrutan.detaillamaran', ['id' => $rekrut->rekrut_id])
        ));

        Session::flash('success', 'Penerimaan mahasiswa magang berhasil. Mahasiswa dapat langsung melakukan pencatatan kegiatan magang');
        return redirect()->back();
    }
}
