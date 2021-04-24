<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\BroadcastLowongan;
use App\Notifications\BroadcastLowonganNotif;
use App\City;
use App\Lowongan;
use App\Fungsi;
use App\Mahasiswa;
use App\Perusahaan;
use App\User;
use Auth;
use DB;
use Mail;
use Notification;
use Session;
use Validator;

class ManageLowonganController extends Controller
{
    public function manage()
    {
        $lowongans = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->select('*', DB::raw('(select count(rekrut_id) from rekruts where rekrut_lowongan_id=lowongan_id) as total_pelamar'))
                            ->where('perusahaan_user_email', Auth::user()->user_email)->get();

    	return view('lowongan.manage', [
            'lowongans' => $lowongans
        ]);
    }
    
    public function list(Request $request)
    {
        $filter = new \stdClass();

        if(!empty($request->filter_perusahaan)) $filter->perusahaan = $request->filter_perusahaan;
        else $filter->perusahaan = "";
        
        if(!empty($request->filter_fungsi)) $filter->fungsi = $request->filter_fungsi;
        else $filter->fungsi = [];
        
        if(!empty($request->filter_city)) $filter->city = $request->filter_city;
        else $filter->city = "";
        
        if(!empty($request->filter_mulaidari)) $filter->mulaidari = $request->filter_mulaidari;
        else $filter->mulaidari = "";
        
        if(!empty($request->filter_mulaisampai)) $filter->mulaisampai = $request->filter_mulaisampai;
        else $filter->mulaisampai = "";

        $lowongans = Lowongan::query();
        $lowongans = $lowongans->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                            ->where('lowongan_status', 'post')
                            ->where('lowongan_jlh_dibutuhkan', '>', 0);

        if(!empty($request->filter_perusahaan)) $lowongans = $lowongans->where('perusahaan_nama', 'like', '%'.$request->filter_perusahaan.'%');

        if(!empty($request->filter_fungsi)) {
            $fungsis = $filter->fungsi;
            $lowongans = $lowongans->where(function ($query) use ($fungsis) {
                foreach($fungsis as $fungsi)
                    $query->orWhere('fungsi_id', $fungsi);
            });
        }

        if(!empty($request->filter_city)) {
            $lowongans = $lowongans->where('city_id', $request->filter_city);
            $city = City::where('city_id', $request->filter_city)->first();
            $filter->city_nama = $city->city_nama;
        }
        
        if(!empty($request->filter_mulaidari)) {
            $lowongans = $lowongans->where('lowongan_tgl_mulai', ">=", $request->filter_mulaidari);
        }
        
        if(!empty($request->filter_mulaisampai)) {
            $lowongans = $lowongans->where('lowongan_tgl_mulai', "<=", $request->filter_mulaisampai);
        }

        $lowongans = $lowongans->paginate(5);

        $fungsis = Fungsi::get();

        return view('lowongan.list', [
            'lowongans' => $lowongans,
            'filter' => $filter,
            'fungsis' => $fungsis,
        ]);
    }

    public function detail($id)
    {
        // DB::enableQueryLog();
        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                            ->where('lowongan_id', $id)
                            ->first();
                            
        // dd(DB::getQueryLog());
        if(empty($lowongan)) return abort(404);
        
        $lowongan->lowongan_requirement = htmlspecialchars_decode($lowongan->lowongan_requirement);
        $lowongan->lowongan_jobdesk     = htmlspecialchars_decode($lowongan->lowongan_jobdesk);

    	return view('lowongan.detail', [
            'lowongan' => $lowongan,
        ]);
    }

    public function add()
    {
        $fungsis = Fungsi::get();

    	return view('lowongan.add', [
            'fungsis' => $fungsis
        ]);
    }
    
    public function save(Request $request)
    {
        $rules = [
            'lowongan_judul'    => 'required',
            'lowongan_city_id'  => 'required|exists:cities,city_id',
            'lowongan_tgl_mulai'=> 'required',
        ];
 
        $messages = [
            'lowongan_judul.required'   => 'Masukan judul lowongan',
            'lowongan_city_id.required' => 'Pilih kota penempatan',
            'dospem_prodi_id.exists'    => 'Kota tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) return abort(404);

        $lowongan = new Lowongan;
        $lowongan->lowongan_perusahaan_id= $perusahaan->perusahaan_id;
        $lowongan->lowongan_status       = $request->lowongan_status;
        $lowongan->lowongan_judul        = $request->lowongan_judul;
        $lowongan->lowongan_fungsi_id    = $request->lowongan_fungsi_id;
        $lowongan->lowongan_city_id      = $request->lowongan_city_id;
        $lowongan->lowongan_tgl_mulai    = $request->lowongan_tgl_mulai;
        $lowongan->lowongan_durasi       = $request->lowongan_durasi_a.'-'.$request->lowongan_durasi_b;
        $lowongan->lowongan_requirement  = htmlspecialchars($request->lowongan_requirement);
        $lowongan->lowongan_jobdesk      = htmlspecialchars($request->lowongan_jobdesk);
        $lowongan->lowongan_jlh_dibutuhkan= $request->lowongan_jlh_dibutuhkan;
        $simpanlowongan = $lowongan->save();

        if($simpanlowongan)
        {
            if($request->lowongan_status=='draft') Session::flash('success', 'Lowongan berhasil disimpan sebagai draft');
            elseif($request->lowongan_status=='post') Session::flash('success', 'Lowongan berhasil disimpan dan dipublikasikan');
            return redirect()->route('lowongan.manage');
        } else {
            Session::flash('error', 'Tambah program studi gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }
    
    public function update(Request $request)
    {
        if(empty($request->lowongan_id)) abort(404);

        $rules = [
            'lowongan_judul'    => 'required',
            'lowongan_city_id'  => 'required|exists:cities,city_id',
            'lowongan_tgl_mulai'=> 'required',
        ];
 
        $messages = [
            'lowongan_judul.required'   => 'Masukan judul lowongan',
            'lowongan_city_id.required' => 'Pilih kota penempatan',
            'dospem_prodi_id.exists'    => 'Kota tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) return abort(404);

        try
        {
            Lowongan::where('lowongan_id',$request->lowongan_id)
                    ->where('lowongan_perusahaan_id',$perusahaan->perusahaan_id)
                ->update([
                    'lowongan_status'       => $request->lowongan_status,
                    'lowongan_judul'        => $request->lowongan_judul,
                    'lowongan_fungsi_id'    => $request->lowongan_fungsi_id,
                    'lowongan_city_id'      => $request->lowongan_city_id,
                    'lowongan_tgl_mulai'    => $request->lowongan_tgl_mulai,
                    'lowongan_durasi'       => $request->lowongan_durasi_a.'-'.$request->lowongan_durasi_b,
                    'lowongan_requirement'  => htmlspecialchars($request->lowongan_requirement),
                    'lowongan_jobdesk'      => htmlspecialchars($request->lowongan_jobdesk),
                    'lowongan_jlh_dibutuhkan'=> $request->lowongan_jlh_dibutuhkan,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        if($request->lowongan_status=='draft') Session::flash('success', 'Lowongan berhasil diedit sebagai draft');
        elseif($request->lowongan_status=='post') Session::flash('success', 'Lowongan berhasil diedit dan dipublikasikan');
        return redirect()->back();
    }
    
    public function edit($id)
    {
        // DB::enableQueryLog();
        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->where('perusahaan_user_email', Auth::user()->user_email )
                            ->where('lowongan_id', $id)
                            ->first();
                            
        // dd(DB::getQueryLog());
        if(empty($lowongan)) return abort(404);

        $fungsis = Fungsi::get();

    	return view('lowongan.edit', [
            'lowongan' => $lowongan,
            'fungsis' => $fungsis
        ]);
    }
    
    public function delete(Request $request)
    {
        if(empty($request->id)) abort(404);
        
        try
        {
            Lowongan::where('lowongan_status','draft')->where('lowongan_id',$request->id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Hapus lowongan berhasil');
        return redirect()->back();
    }

    public function broadcast(Request $request)
    {
        if(empty($request->prodi_id)) abort(404);

        $rules = [
            'lowongan_id'   => 'required',
        ];

        $messages = [
            'lowongan_id.required'  => 'Silahkan pilih lowongan yang akan dilakukan broadcast',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->where('perusahaan_user_email', Auth::user()->user_email )
                            ->where('lowongan_id', $request->lowongan_id)
                            ->first();

        $mahasiswas = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->where('dospem_prodi_id', $request->prodi_id)
                                ->where('mahasiswa_status', 'mencari')
                                ->get();
        $count = 0;
        foreach($mahasiswas as $mahasiswa)
        {
            try
            {
                Mail::to($mahasiswa->mahasiswa_user_email)->send(new BroadcastLowongan($lowongan, $mahasiswa));

            } catch (\Illuminate\Database\QueryException $e) {
                Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
                return redirect()->back();
            }
            
            $count++;
            
            $receiver = User::where('user_email', $mahasiswa->mahasiswa_user_email)->first();
            Notification::send($receiver, new BroadcastLowonganNotif($request->lowongan_id, $lowongan->lowongan_judul, $lowongan->perusahaan_nama));
        }

        Session::flash('success', 'Broadcast berhasil dikirim ke '.$count.' mahasiswa');
        return redirect()->back();
    }

    public function autocom(Request $request)
    {
        $json = [];

        // if(!empty($request->query('q'))){
            // DB::enableQueryLog();
            $json = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->where('perusahaan_user_email', Auth::user()->user_email )
                            ->where('lowongan_judul', 'LIKE', '%'.$request->query('q').'%')
                            ->select('lowongan_id as id', 'lowongan_judul as text')
                            ->get()->take(5);
            // dd(DB::getQueryLog());
        // }
        echo json_encode($json);
    }
}
