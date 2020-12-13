<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;
use App\Rekrut;
use Artisan;
use Auth;
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
                        ->where('rekrut_status', "lulus")
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);

        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

    	return view('kegiatan.manage', [
            'filter' => $filter,
            'rekrut' => $rekrut
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
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('rekrut_status', "lulus")
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($rekrut)) abort(404);
        
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut->rekrut_id)
                            ->where('kegiatan_tgl', $kegiatan_tgl )->first();
        if(empty($kegiatan)) abort(404);

        $kegiatan->kegiatan_desc = htmlspecialchars_decode($kegiatan->kegiatan_desc);
        
        return view('kegiatan.add', [
            'kegiatan' => $kegiatan,
            'kegiatan_tgl' => $kegiatan_tgl,
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
}
