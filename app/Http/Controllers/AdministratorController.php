<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lowongan;
use App\Prodi;
use App\Perusahaan;
use App\Univ;
use Auth;
use Session;

class AdministratorController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function kampuslist(Request $request)
    {
        $filter = new \stdClass();

        if(!empty($request->filter_status)) $filter->status = $request->filter_status;
        else $filter->status = "";

        $univs = Univ::join('users', 'univs.univ_user_email', '=', 'users.user_email');

        if($request->filter_status=='unverified') {
            $univs = $univs->whereNotNull('univ_verified');
        }
        elseif($request->filter_status=='verified') {
            $univs = $univs->whereNull('univ_verified');
        }

        $univs = $univs->get();

        return view('admin.kampuslist', [
            'univs' => $univs,
            'filter' => $filter,
        ]);
    }
    
    public function kampusdetail($id)
    {
        $univ = Univ::leftJoin('cities', 'univs.univ_city_id', '=', 'cities.city_id')
                    ->where('univs.univ_id', $id)
                    ->first();
        if(empty($univ)) abort(404);

        $prodis = Prodi::where('prodi_univ_id', $id)->get();

    	return view('admin.kampusdetail', [
            'univ' => $univ,
            'prodis' => $prodis,
        ]);
    }

    public function kampusverify($univ_id)
    {
        $univ = Univ::where('univ_id', $univ_id )->first();
        if(empty($univ)) abort(404);

        try
        {
            Univ::where('univ_id',$univ_id)
                ->update([
                    'univ_verified'      => date("Y-m-d H:i:s"),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Verifikasi kampus berhasil');
        return redirect()->route('admin.kampuslist');
    }
    
    public function perusahaanlist(Request $request)
    {
        $filter = new \stdClass();

        if(!empty($request->filter_status)) $filter->status = $request->filter_status;
        else $filter->status = "";

        $perusahaans = Perusahaan::join('users', 'perusahaans.perusahaan_user_email', '=', 'users.user_email');

        if($request->filter_status=='unverified') {
            $perusahaans = $perusahaans->whereNotNull('perusahaan_verified');
        }
        elseif($request->filter_status=='verified') {
            $perusahaans = $perusahaans->whereNull('perusahaan_verified');
        }

        $perusahaans = $perusahaans->get();

        return view('admin.perusahaanlist', [
            'perusahaans' => $perusahaans,
            'filter' => $filter,
        ]);
    }
    
    public function perusahaandetail($id)
    {
        $perusahaan = Perusahaan::leftJoin('cities', 'cities.city_id', '=', 'perusahaans.perusahaan_city_id')
                                ->where('perusahaan_id', $id )->first();
        if(empty($perusahaan)) abort(404);

        $lowongans = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                             ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                             ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                             ->where('lowongan_perusahaan_id', $id )
                             ->where('lowongan_status', 'post')
                             ->get();

    	return view('admin.perusahaandetail', [
            'perusahaan' => $perusahaan,
            'lowongans' => $lowongans,
        ]);
    }

    public function perusahaanverify($perusahaan_id)
    {
        $perusahaan = Perusahaan::where('perusahaan_id', $perusahaan_id )->first();
        if(empty($perusahaan)) abort(404);

        try
        {
            Perusahaan::where('perusahaan_id',$perusahaan_id)
                ->update([
                    'perusahaan_verified'      => date("Y-m-d H:i:s"),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Verifikasi perusahaan berhasil');
        return redirect()->route('admin.perusahaanlist');
    }
}
