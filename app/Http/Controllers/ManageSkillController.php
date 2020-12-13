<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use App\Skill;
use Auth;
use Session;
use Validator;

class ManageSkillController extends Controller
{
    public function manage()
    {
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                            ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                            ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
                            
        if(empty($mahasiswa)) return abort(404);

        $skills = Skill::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'skills.skill_mahasiswa_id')
                       ->where('mahasiswa_user_email', Auth::user()->user_email)
                       ->get();

    	return view('mahasiswa.manage_skill', [
            'mahasiswa' => $mahasiswa,
            'skills' => $skills
        ]);
    }
    
    public function save(Request $request)
    {
        $rules = [
            'skill_nama'      => 'required',
        ];
 
        $messages = [
            'skill_nama.required'       => 'Masukan nama skill',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $mahasiswa = Mahasiswa::where('mahasiswa_user_email', Auth::user()->user_email )->first();
        if(empty($mahasiswa)) return abort(404);

        $skill = new Skill;
        $skill->skill_mahasiswa_id  = $mahasiswa->mahasiswa_id;
        $skill->skill_nama          = $request->skill_nama;
        $simpanskill = $skill->save();

        if($simpanskill)
        {
            Session::flash('success', 'Tambah skill berhasil');
            return redirect()->back();
        } else {
            Session::flash('error', 'Tambah skill gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        if(empty($request->id)) abort(404);

        try
        {
            Skill::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'skills.skill_mahasiswa_id')
                    ->where('mahasiswa_user_email', Auth::user()->user_email)
                    ->where('skill_id', $request->id)
                    ->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Hapus Skill berhasil');
        return redirect()->back();
    }
}
