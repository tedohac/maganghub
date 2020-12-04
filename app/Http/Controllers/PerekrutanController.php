<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lowongan;
use App\Mahasiswa;
use App\Rekrut;
use Auth;
use Session;

class PerekrutanController extends Controller
{
    public function apply($id)
    {
        $user_role = Auth::user()->user_role;
        if($user_role != 'mahasiswa') return abort(404);

        $lowongan = Lowongan::where('lowongan_id', $id)->first();
        if(empty($lowongan)) return abort(404);
        
        $mahasiswa = Mahasiswa::where('mahasiswa_user_email', Auth::user()->user_email)->first();
        if(empty($lowongan)) return abort(404);

        if($mahasiswa->mahasiswa_status!='mencari') {
            Session::flash('error', 'Anda sudah mendapatkan tempat magang');
            return redirect()->back();
        }

        $rekrut = Rekrut::where('rekrut_mahasiswa_id', $mahasiswa->mahasiswa_id)
                        ->where('rekrut_lowongan_id', $lowongan->lowongan_id)->get();
        if(!empty($rekrut)) {
            Session::flash('error', 'Anda sudah melamar pada lowongan ini');
            return redirect()->back();
        }
        

        $rekrut = new Rekrut;
        $rekrut->rekrut_lowongan_id  = $lowongan->lowongan_id;
        $rekrut->rekrut_mahasiswa_id = $mahasiswa->mahasiswa_id;
        $rekrut->rekrut_status       = 'melamar';
        $simpanrekrut = $rekrut->save();
                            
        if($simpanrekrut)
        {
            Session::flash('success', 'Melamar lowongan berhasil, mohon tunggu perusahaan mengirim undangan interview kepada anda.');
            return redirect()->back();
        } else {
            Session::flash('error', 'Melamar lowongan gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }

    public function manage($id)
    {
        $user_role = Auth::user()->user_role;
        if($user_role != 'perusahaan') return abort(404);

        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->where('lowongan_id', $id)
                            ->where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($lowongan)) return abort(404);
        
        $rekrut = Rekrut::where('rekrut_lowongan_id', $id)->get();

    	return view('lowongan.manage_rekrut', [
            'lowongan' => $lowongan,
            'rekrut' => $rekrut,
        ]);
    }
}
