<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Mahasiswa;
use App\Skill;
use Artisan;
use Auth;
use Session;
use Storage;
use Validator;

class ProfilMahasiswaController extends Controller
{

    public function detail($id)
    {
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                                ->leftJoin('cities', 'cities.city_id', '=', 'mahasiswas.mahasiswa_city_id')
                                ->where('mahasiswa_id', $id )->first();
        if(empty($mahasiswa)) abort(404);

        $skills = Skill::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'skills.skill_mahasiswa_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email)
                        ->get();

    	return view('mahasiswa.detail', [
            'mahasiswa' => $mahasiswa,
            'skills' => $skills
        ]);
    }
    
    public function edit()
    {
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                                ->leftJoin('cities', 'cities.city_id', '=', 'mahasiswas.mahasiswa_city_id')
                                ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($mahasiswa)) abort(404);

    	return view('mahasiswa.edit', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function update(Request $request)
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($mahasiswa)) abort(404);
 
        $rules = [
            'mahasiswa_nama' => 'required',
        ];

        $messages = [
            'mahasiswa_nama.required' => 'Masukan nama Mahasiswa',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        try
        {
            $filename_mahasiswa_profile_pict = "";
            if($request->mahasiswa_profile_pict!="") 
            {
                $filename_mahasiswa_profile_pict = $mahasiswa->mahasiswa_id.'.'.$request->file('mahasiswa_profile_pict')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'mahasiswa_profile/'.$mahasiswa->mahasiswa_profile_pict )) Storage::delete('public/mahasiswa_profile/'.$mahasiswa->mahasiswa_profile_pict);
                $request->file('mahasiswa_profile_pict')->storeAs('public/mahasiswa_profile', $filename_mahasiswa_profile_pict);

                Artisan::call('cache:clear');
            }
            
            $filename_mahasiswa_cv = "";
            if($request->mahasiswa_cv!="") 
            {
                $filename_mahasiswa_cv = $mahasiswa->mahasiswa_id.'.'.$request->file('mahasiswa_cv')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'mahasiswa_cv/'.$mahasiswa->mahasiswa_cv )) Storage::delete('public/mahasiswa_cv/'.$mahasiswa->mahasiswa_cv);
                $request->file('mahasiswa_cv')->storeAs('public/mahasiswa_cv', $filename_mahasiswa_cv);

                Artisan::call('cache:clear');
            }
            
            $filename_mahasiswa_khs = "";
            if($request->mahasiswa_khs!="") 
            {
                $filename_mahasiswa_khs = $mahasiswa->mahasiswa_id.'.'.$request->file('mahasiswa_khs')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'mahasiswa_khs/'.$mahasiswa->mahasiswa_khs )) Storage::delete('public/mahasiswa_khs/'.$mahasiswa->mahasiswa_khs);
                $request->file('mahasiswa_khs')->storeAs('public/mahasiswa_khs', $filename_mahasiswa_khs);

                Artisan::call('cache:clear');
            }

            Mahasiswa::where('mahasiswa_id',$mahasiswa->mahasiswa_id)
                ->update([
                    'mahasiswa_nama'            => $request->mahasiswa_nama,
                    'mahasiswa_tempat_lahir'    => isset($request->mahasiswa_tempat_lahir) ? $request->mahasiswa_tempat_lahir : null,
                    'mahasiswa_tgl_lahir'       => isset($request->mahasiswa_tgl_lahir) ? $request->mahasiswa_tgl_lahir : null,
                    'mahasiswa_no_tlp'          => isset($request->mahasiswa_no_tlp) ? $request->mahasiswa_no_tlp : null,
                    'mahasiswa_city_id'         => isset($request->mahasiswa_city_id) ? $request->mahasiswa_city_id : null,
                    'mahasiswa_alamat'          => isset($request->mahasiswa_alamat) ? $request->mahasiswa_alamat : null,
                    'mahasiswa_profile_pict'    => $request->mahasiswa_profile_pict!="" ? $filename_mahasiswa_profile_pict : $mahasiswa->mahasiswa_profile_pict,
                    'mahasiswa_cv'              => $request->mahasiswa_cv!="" ? $filename_mahasiswa_cv : $mahasiswa->mahasiswa_cv,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Ubah detail profil berhasil');
        return redirect('mahasiswa/detail/'.$mahasiswa->mahasiswa_id);
    }
}
