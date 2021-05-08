<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;
use App\Mahasiswa;
use App\Rekrut;
use App\Skill;
use Artisan;
use Auth;
use PDF;
use Session;
use Storage;
use Validator;

class ManageKegiatanController extends Controller
{
    public function manage(Request $request)
    {
        $filter = new \stdClass();

        date_default_timezone_set('Asia/Jakarta');
        if(!empty($request->filter_month)) $filter->month = $request->filter_month;
        else $filter->month = date('Y').'-'.date('m');
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->where(function ($query) {
                            $query->orWhere('rekrut_status', "lulus");
                            $query->orWhere('rekrut_status', "finishmhs");
                            $query->orWhere('rekrut_status', "finishprs");
                        })
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);

        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

    	return view('kegiatan.manage', [
            'filter' => $filter,
            'rekrut' => $rekrut
        ]);
    }
    
    public function mentorview($rekrut_id, Request $request)
    {
        $filter = new \stdClass();

        date_default_timezone_set('Asia/Jakarta');
        if(!empty($request->filter_month)) $filter->month = $request->filter_month;
        else $filter->month = date('Y').'-'.date('m');
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('rekrut_id', $rekrut_id)
                        ->where(function ($query) {
                            $query->orWhere('rekrut_status', "lulus");
                            $query->orWhere('rekrut_status', "finishmhs");
                            $query->orWhere('rekrut_status', "finishprs");
                        })
                        ->where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);

        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

    	return view('kegiatan.mentorview', [
            'filter' => $filter,
            'rekrut' => $rekrut,
            'skills' => $skills
        ]);
    }
    
    public function dospemview($rekrut_id, Request $request)
    {
        $filter = new \stdClass();

        date_default_timezone_set('Asia/Jakarta');
        if(!empty($request->filter_month)) $filter->month = $request->filter_month;
        else $filter->month = date('Y').'-'.date('m');
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('rekrut_id', $rekrut_id)
                        ->where(function ($query) {
                            $query->orWhere('rekrut_status', "lulus");
                            $query->orWhere('rekrut_status', "finishmhs");
                            $query->orWhere('rekrut_status', "finishprs");
                        })->first();
        if(empty($rekrut)) abort(404);

        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

    	return view('dospem.kegiatan', [
            'filter' => $filter,
            'rekrut' => $rekrut,
            'skills' => $skills
        ]);
    }

    public function detail($rekrut_id, $kegiatan_tgl)
    {
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut_id)
                            ->where('kegiatan_tgl', $kegiatan_tgl )->first();
        if(empty($kegiatan)) abort(404);
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('rekrut_id', $rekrut_id)
                        ->where(function ($query) {
                            $query->orWhere('rekrut_status', "lulus");
                            $query->orWhere('rekrut_status', "finishmhs");
                            $query->orWhere('rekrut_status', "finishprs");
                        })->first();
        if(empty($rekrut)) abort(404);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

        return view('kegiatan.detail', [
            'rekrut' => $rekrut,
            'kegiatan' => $kegiatan,
            'skills' => $skills
        ]);
    }

    public function detailmhs($rekrut_id, $kegiatan_tgl)
    {
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut_id)
                            ->where('kegiatan_tgl', $kegiatan_tgl )->first();
        if(empty($kegiatan)) abort(404);
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('rekrut_id', $rekrut_id)
                        ->where(function ($query) {
                            $query->orWhere('rekrut_status', "lulus");
                            $query->orWhere('rekrut_status', "finishmhs");
                            $query->orWhere('rekrut_status', "finishprs");
                        })
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

        return view('kegiatan.detail', [
            'rekrut' => $rekrut,
            'kegiatan' => $kegiatan,
            'skills' => $skills
        ]);
    }
    
    public function add($kegiatan_tgl)
    {
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('rekrut_status', "lulus")
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);
        
        // if already exists
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut->rekrut_id)
                            ->where('kegiatan_tgl', $kegiatan_tgl )->first();
        if(!empty($kegiatan)) abort(404);

        return view('kegiatan.add', [
            'kegiatan_tgl' => $kegiatan_tgl,
        ]);
    }
    
    public function edit($kegiatan_tgl)
    {
        $kegiatan = Kegiatan::join('rekruts', 'rekruts.rekrut_id', '=', 'kegiatans.kegiatan_rekrut_id')
                            ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email )
                            ->where('kegiatan_tgl', $kegiatan_tgl )->first();
        if(empty($kegiatan)) abort(404);
        
        return view('kegiatan.edit', [
            'kegiatan' => $kegiatan,
        ]);
    }
    
    public function save(Request $request)
    {
 
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('rekrut_status', "lulus")
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);
        
        // if already exists
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut->rekrut_id)
                            ->where('kegiatan_tgl', $rekrut->kegiatan_tgl )->first();
        if(!empty($kegiatan)) abort(404);

        $rules = [
            'kegiatan_desc' => 'required',
            'kegiatan_path' => 'required',
        ];
 
        $messages = [
            'kegiatan_desc.required'=> 'Pilih kota penempatan',
            'kegiatan_path.required'=> 'Kota tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        try
        {
            $tglformated = date('Ymd', strtotime($request->kegiatan_tgl));
            $filename_kegiatan_path = $rekrut->rekrut_id.'-'.$tglformated.'.'.$request->file('kegiatan_path')->getClientOriginalExtension();
                
            // delete if exists
            if (Storage::disk('public')->exists( 'kegiatan/'.$filename_kegiatan_path )) Storage::delete('public/kegiatan/'.$filename_kegiatan_path);
            $request->file('kegiatan_path')->storeAs('public/kegiatan', $filename_kegiatan_path);

            Artisan::call('cache:clear');
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        $kegiatan = new Kegiatan;
        $kegiatan->kegiatan_rekrut_id   = $rekrut->rekrut_id;
        $kegiatan->kegiatan_tgl         = $request->kegiatan_tgl;
        $kegiatan->kegiatan_path        = $filename_kegiatan_path;
        $kegiatan->kegiatan_desc        = htmlspecialchars($request->kegiatan_desc);
        $simpankegiatan = $kegiatan->save();

        if($simpankegiatan)
        {
            Session::flash('success', 'Berhasil menyimpan kegiatan untuk tanggal '.date('d F Y', strtotime($request->kegiatan_tgl)));
            return redirect()->route('kegiatan.manage');
        } else {
            Session::flash('error', 'Menyimpan kegiatan gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }
    
    public function update(Request $request)
    {
        if(empty($request->kegiatan_tgl)) abort(404);
        
        // if not exists
        $kegiatan = Kegiatan::join('rekruts', 'rekruts.rekrut_id', '=', 'kegiatans.kegiatan_rekrut_id')
                            ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email )
                            ->where('kegiatan_tgl', $request->kegiatan_tgl )->first();
        if(empty($kegiatan)) abort(404);

        $rules = [
            'kegiatan_desc' => 'required',
        ];
 
        $messages = [
            'kegiatan_desc.required'=> 'Pilih kota penempatan',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        // if kegiatan_path is not empty
        if($request->kegiatan_path!="")
        {
            try
            {
                $tglformated = date('Ymd', strtotime($request->kegiatan_tgl));
                $filename_kegiatan_path = $kegiatan->kegiatan_rekrut_id.'-'.$tglformated.'.'.$request->file('kegiatan_path')->getClientOriginalExtension();
                    
                // delete if exists
                if (Storage::disk('public')->exists( 'kegiatan/'.$kegiatan->kegiatan_path )) Storage::delete('public/kegiatan/'.$kegiatan->kegiatan_path);
                $request->file('kegiatan_path')->storeAs('public/kegiatan', $filename_kegiatan_path);
    
                Artisan::call('cache:clear');
                    
                Kegiatan::where('kegiatan_id',$kegiatan->kegiatan_id)
                        ->update([
                            'kegiatan_path' => $filename_kegiatan_path,
                            'kegiatan_desc' => htmlspecialchars($request->kegiatan_desc),
                            'kegiatan_verify_mentor' => null,
                        ]);
            } catch (\Illuminate\Database\QueryException $e) {
                Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
                return redirect()->back();
            }
        }
        else
        {
            try
            {
                Kegiatan::where('kegiatan_id',$kegiatan->kegiatan_id)
                        ->update([
                            'kegiatan_desc' => htmlspecialchars($request->kegiatan_desc),
                            'kegiatan_verify_mentor' => null,
                        ]);
            } catch (\Illuminate\Database\QueryException $e) {
                Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
                return redirect()->back();
            }
        }

        Session::flash('success', 'Berhasil menyimpan perubahan pada kegiatan untuk tanggal '.date('d F Y', strtotime($request->kegiatan_tgl)));
        return redirect()->route('kegiatan.manage');
    }
    
    public function delete($kegiatan_tgl)
    {
        if(empty($kegiatan_tgl)) abort(404);

        // if not exists
        $kegiatan = Kegiatan::join('rekruts', 'rekruts.rekrut_id', '=', 'kegiatans.kegiatan_rekrut_id')
                            ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email )
                            ->where('kegiatan_tgl', $kegiatan_tgl )->first();
        if(empty($kegiatan)) abort(404);

        try
        {
            // delete if exists
            if (Storage::disk('public')->exists( 'kegiatan/'.$kegiatan->kegiatan_path )) Storage::delete('public/kegiatan/'.$kegiatan->kegiatan_path);

            Kegiatan::where('kegiatan_id',$kegiatan->kegiatan_id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Hapus kegiatan berhasil untuk tanggal '.date('d F Y', strtotime($kegiatan_tgl)));
        return redirect()->route('kegiatan.manage');
    }
    
    public function verify($kegiatan_id)
    {
        // if not exists
        $kegiatan = Kegiatan::join('rekruts', 'rekruts.rekrut_id', '=', 'kegiatans.kegiatan_rekrut_id')
                            ->join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                            ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->where('perusahaan_user_email', Auth::user()->user_email )
                            ->where('kegiatan_id', $kegiatan_id )->first();
        if(empty($kegiatan)) abort(404);

        try
        {
            date_default_timezone_set('Asia/Jakarta');
            
            Kegiatan::where('kegiatan_id',$kegiatan_id)
                    ->update([
                        'kegiatan_verify_mentor' => date("Y-m-d H:i:s"),
                    ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Berhasil memverifikasi kegiatan magang untuk tanggal '.date('d F Y', strtotime($kegiatan->kegiatan_tgl)));
        return redirect()->route('kegiatan.mentorview', ['id' => $kegiatan->rekrut_id]);
    }
    
    public function print()
    {        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where(function ($query) {
                            $query->orWhere('rekrut_status', "lulus");
                            $query->orWhere('rekrut_status', "finishmhs");
                            $query->orWhere('rekrut_status', "finishprs");
                        })
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);

        $kegiatans = Kegiatan::where('kegiatan_rekrut_id', $rekrut->rekrut_id)->get();

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

        $pdf = PDF::loadview('kegiatan.printpreview',[
            'rekrut' => $rekrut,
            'kegiatans' => $kegiatans,
            'skills' => $skills
        ]);
        return $pdf->stream();
    }
    
    public function finishmahasiswa(Request $request)
    {
        // if not exists
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('rekrut_status', "lulus")
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
                if(empty($rekrut)) abort(404);

        if($request->rekrut_rating_mahasiswa>10 || $request->rekrut_rating_mahasiswa<1)
        {
            Session::flash('error', 'Masukkan rating untuk perusahaan dengan skala 1-10.');
            return redirect()->back();
        }

        try
        {
            date_default_timezone_set('Asia/Jakarta');
                
            Rekrut::where('rekrut_id',$rekrut->rekrut_id)
                    ->update([
                        'rekrut_status'           => 'finishmhs',
                        'rekrut_rating_mahasiswa' => $request->rekrut_rating_mahasiswa,
                        'rekrut_finish_mahasiswa' => date("Y-m-d H:i:s"),
                    ]);
                    
            Mahasiswa::where('mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                ->update([
                    'mahasiswa_status' => 'selesai',
                ]);

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon hubungi admin MagangHub '.$e);
            return redirect()->back();
        }

        Session::flash('success', 'Berhasil menyelesaikan magang, semoga pengalaman selama magang bermanfaat untuk masa depan anda!');
        return redirect()->back();
    }
    
    public function finishperusahaan(Request $request)
    {
        // if not exists
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->where('rekrut_status', "finishmhs")
                        ->where('perusahaan_user_email', Auth::user()->user_email )->first();
                if(empty($rekrut)) abort(404);

        if($request->rekrut_rating_perusahaan>10 || $request->rekrut_rating_perusahaan<1 || $request->rekrut_feedback=="")
        {
            Session::flash('error', 'Masukkan feedback dan rating untuk mahasiswa dengan skala 1-10.');
            return redirect()->back();
        }

        try
        {
            date_default_timezone_set('Asia/Jakarta');
                
            Rekrut::where('rekrut_id',$rekrut->rekrut_id)
                    ->update([
                        'rekrut_status'            => 'finishprs',
                        'rekrut_rating_perusahaan'  => $request->rekrut_rating_perusahaan,
                        'rekrut_finish_perusahaan'  => date("Y-m-d H:i:s"),
                        'rekrut_feedback'           => $request->rekrut_feedback,
                    ]);
                    
            Mahasiswa::where('mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                ->update([
                    'mahasiswa_status' => 'selesai',
                ]);

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon hubungi admin MagangHub '.$e);
            return redirect()->back();
        }

        Session::flash('success', 'Berhasil menyelesaikan magang, semoga pengalaman selama magang bermanfaat untuk masa depan anda!');
        return redirect()->back();
    }
}
