<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\Csv\Reader;
use App\Mail\NewMahasiswaEmail;
use App\Rules\DospemExistsMahasiswaRule;
use App\Rules\NimMahasiswaRule;
use App\Rules\NimMahasiswaUpdateRule;
use App\Dospem;
use App\Mahasiswa;
use App\Prodi;
use App\Univ;
use App\User;
use Artisan;
use Auth;
use Hash;
use Mail;
use Session;
use Storage;
use Validator;

class ManageMahasiswaController extends Controller
{
    public function manage()
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $mahasiswas = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('users', 'users.user_email', '=', 'mahasiswas.mahasiswa_user_email')
                        ->where('prodis.prodi_univ_id', $univ->univ_id)
                        ->get();

    	return view('kampus.manage_mahasiswa', [
            'univ' => $univ,
            'mahasiswas' => $mahasiswas
        ]);
    }
    
    public function pantau()
    {
        $dospem = Dospem::where('dospem_user_email', Auth::user()->user_email )->first();
        if(empty($dospem)) abort(404);

        $mahasiswas = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('users', 'users.user_email', '=', 'mahasiswas.mahasiswa_user_email')
                                ->where('mahasiswa_dospem_id', $dospem->dospem_id)
                                ->get();

    	return view('dospem.manage_mahasiswa', [
            'mahasiswas' => $mahasiswas
        ]);
    }
    
    public function importform()
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

    	return view('kampus.import_mahasiswa', [
            'univ' => $univ
        ]);
    }
    
    public function save(Request $request)
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $rules = [
            'mahasiswa_nim'         => ['required', new NimMahasiswaRule($univ->univ_id)],
            'mahasiswa_nama'        => 'required',
            'mahasiswa_dospem_id'   => ['required', new DospemExistsMahasiswaRule($univ->univ_id)],
            'mahasiswa_user_email'  => 'required|email|unique:users,user_email',
        ];
 
        $messages = [
            'mahasiswa_nim.required'        => 'Masukan NIM Mahasiswa',
            'mahasiswa_nama.required'       => 'Masukan nama Mahasiswa',
            'mahasiswa_dospem_id.required'  => 'Pilih Dosen Pembimbing',
            'mahasiswa_user_email.required' => 'Masukan e-mail Mahasiswa',
            'mahasiswa_user_email.email'    => 'Format e-mail tidak valid',
            'mahasiswa_user_email.unique'   => 'E-mail sudah terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $passwordTemp = Str::random(6);

        $user = new User;
        $user->user_email        = strtolower($request->mahasiswa_user_email);
        $user->user_role         = 'mahasiswa';
        $user->user_status       = '1';
        $user->user_password     = Hash::make($passwordTemp);
        $user->user_verify_token = Str::random(32);
        $simpanuser = $user->save();

        $mahasiswa = new Mahasiswa;
        $mahasiswa->mahasiswa_user_email    = strtolower($request->mahasiswa_user_email);
        $mahasiswa->mahasiswa_dospem_id     = $request->mahasiswa_dospem_id;
        $mahasiswa->mahasiswa_nim           = $request->mahasiswa_nim;
        $mahasiswa->mahasiswa_nama          = $request->mahasiswa_nama;
        $mahasiswa->mahasiswa_status        = 'mencari';
        $simpanmahasiswa = $mahasiswa->save();

        if($simpanuser && $simpanmahasiswa)
        {
            $prodi = Prodi::join('dospems', 'dospems.dospem_prodi_id', '=', 'prodis.prodi_id')
                          ->where('dospems.dospem_id', $request->mahasiswa_dospem_id)->first();
            Mail::to($request->mahasiswa_user_email)->send(new NewMahasiswaEmail($request, $univ->univ_nama, $prodi->prodi_nama, $user->user_verify_token, $passwordTemp));

            Session::flash('success', 'Tambah mahasiswa berhasil');
            return redirect()->back();
        } else {
            Session::flash('error', 'Tambah mahasiswa gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }
    
    public function update(Request $request)
    {
        if(empty($request->edit_id)) abort(404);

        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        // get mahasiswa's original email
        $mahasiswa = Mahasiswa::where('mahasiswa_id', $request->edit_id )->first();
        if(empty($mahasiswa)) abort(404);

        $rules = [
            'mahasiswa_nim'         => ['required', new NimMahasiswaUpdateRule($univ->univ_id, $request->edit_id)],
            'mahasiswa_nama'        => 'required',
            'mahasiswa_dospem_id'   => ['required', new DospemExistsMahasiswaRule($univ->univ_id)],
            'mahasiswa_user_email'  => 'required|email|unique:users,user_email,'.$mahasiswa->mahasiswa_user_email.',user_email',
        ];

        $messages = [
            'mahasiswa_nim.required'        => 'Masukan NIM Mahasiswa',
            'mahasiswa_nama.required'       => 'Masukan nama Mahasiswa',
            'mahasiswa_dospem_id.required'  => 'Pilih Dosen Pembimbing',
            'mahasiswa_user_email.required' => 'Masukan e-mail Mahasiswa',
            'mahasiswa_user_email.email'    => 'Format e-mail tidak valid',
            'mahasiswa_user_email.unique'   => 'E-mail sudah terdaftar',
        ];
 
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        try
        {
            Mahasiswa::where('mahasiswa_id',$request->edit_id)
                ->update([
                    'mahasiswa_nim'         => $request->mahasiswa_nim,
                    'mahasiswa_nama'        => $request->mahasiswa_nama,
                    'mahasiswa_dospem_id'   => $request->mahasiswa_dospem_id,
                ]);

            // if email changed
            if($request->mahasiswa_user_email!=$mahasiswa->mahasiswa_user_email)
            {
                Mahasiswa::where('mahasiswa_id',$request->edit_id)
                    ->update([
                        'mahasiswa_user_email' => null,
                    ]);

                $passwordTemp = Str::random(6);
                $verify_token = Str::random(32);
                User::where('user_email', $mahasiswa->mahasiswa_user_email)
                    ->update([
                        'user_email'        => $request->mahasiswa_user_email,
                        'user_password'     => Hash::make($passwordTemp),
                        'user_verify_token' => $verify_token,
                        'user_status'       => '1',
                    ]);

                Mahasiswa::where('mahasiswa_id',$request->edit_id)
                    ->update([
                        'mahasiswa_user_email' => $request->mahasiswa_user_email,
                    ]);

                // send email verification
                $params = new \stdClass();
                $params->mahasiswa_user_email  = $request->mahasiswa_user_email;
                $params->mahasiswa_nim         = $request->mahasiswa_nim;
                $params->mahasiswa_nama        = $request->mahasiswa_nama;

                $prodi = Prodi::join('dospems', 'dospems.dospem_prodi_id', '=', 'prodis.prodi_id')
                                ->where('dospem_id', $request->mahasiswa_dospem_id)->first();
                Mail::to($request->mahasiswa_user_email)->send(new NewMahasiswaEmail($params, $univ->univ_nama, $prodi->prodi_nama, $verify_token, $passwordTemp));

                Session::flash('success', 'Edit mahasiswa berhasil, mahasiswa memerlukan verifikasi email ulang karena e-mail telah berubah.');
                return redirect()->back();
            }
            else {
                Session::flash('success', 'Edit mahasiswa berhasil.');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub ');
            return redirect()->back();
        }

    }

    public function importprocess(Request $request)
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);
        
        $rules = [
            'import_file'           => 'required|mimes:csv,txt',
        ];
 
        $messages = [
            'import_file.required'  => 'Pilih file CSV yang akan di-import',
            'import_file.mimes'     => 'File import harus dengan ekstensi CSV',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $filename = 'temp_import_mahasiswa.csv';

        // uploading
        try
        {
            // delete if exists
            if (Storage::disk('public')->exists( 'temp/'.$filename )) Storage::delete('public/temp/'.$filename);
            $request->file('import_file')->storeAs('public/temp', $filename);

            Artisan::call('cache:clear');

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi [1]');
            return redirect()->back();
        }

        $csv = Reader::createFromPath(storage_path('app/public/temp/'.$filename), 'r');
        
        // skip first row
        // $csv->setHeaderOffset(0);
        $rownum = -1;
        $success = 0;
        $errorrow = array();
        foreach ($csv as $row) 
        {// begin for
            $rownum++;

            // validate column
            if($rownum==0)
            {
                if($row[0]!='NIM' || $row[1]!='Nama Mahasiswa' || $row[2]!='NIK DOSPEM' || $row[3]!='E-Mail Mahasiswa') {
                    Session::flash('error', 'Kolom tidak sesuai template');
                    return redirect()->back();
                }

                continue;
            }

            // skipping row which has column not 4
            if(count($row)!=4) {
                array_push($errorrow, $rownum.': kolom tidak sesuai');
                continue;
            }

            // all column not nullable
            if($row[0]=='' || $row[1]=='' || $row[2]=='' || $row[3]=='') {
                array_push($errorrow, $rownum.': ada kolom kosong');
                continue;
            }

            // validate email format
            if (!filter_var($row[3], FILTER_VALIDATE_EMAIL)) {
                array_push($errorrow, $rownum.': format e-mail salah');
                continue;
            }
            
            // unique NIM
            $datacheck = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                    ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                    ->where('prodis.prodi_univ_id', $univ->univ_id)
                                    ->where('mahasiswa_nim', $row[0])->first();
            if(!empty($datacheck)){
                array_push($errorrow, $rownum.': NIM sudah terdaftar');
                continue;
            }

            // check NIM DOSPEM
            $datacheckDospem = Dospem::join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->where('prodis.prodi_univ_id', $univ->univ_id)
                                ->where('dospems.dospem_nik', $row[2])->first();
            if(empty($datacheckDospem)){
                array_push($errorrow, $rownum.': DOSPEM tidak terdaftar');
                continue;
            }

            // unique email
            $datacheck = User::where('user_email', $row[3])->first();
            if(!empty($datacheck)){
                array_push($errorrow, $rownum.': e-mail sudah terdaftar');
                continue;
            }
            
            $passwordTemp = Str::random(6);

            $user = new User;
            $user->user_email        = strtolower($row[3]);
            $user->user_role         = 'mahasiswa';
            $user->user_status       = '1';
            $user->user_password     = Hash::make($passwordTemp);
            $user->user_verify_token = Str::random(32);
            $simpanuser = $user->save();

            $mahasiswa = new Mahasiswa;
            $mahasiswa->mahasiswa_user_email= strtolower($row[3]);
            $mahasiswa->mahasiswa_dospem_id = $datacheckDospem->dospem_id;
            $mahasiswa->mahasiswa_nim       = $row[0];
            $mahasiswa->mahasiswa_nama      = $row[1];
            $mahasiswa->mahasiswa_status    = 'mencari';
            $simpanmahasiswa = $mahasiswa->save();

            if(!$simpanuser || !$simpanmahasiswa){
                Session::flash('error', 'Import data mahasiswa gagal! Mohon hubungi admin MagangHub');
                return redirect()->back();
            }
            
            // send email verification
            $params = new \stdClass();
            $params->mahasiswa_user_email  = strtolower($row[3]);
            $params->mahasiswa_nim         = $row[0];
            $params->mahasiswa_nama        = $row[1];
            
            Mail::to(strtolower($row[3]))->send(new NewMahasiswaEmail($params, $univ->univ_nama, $datacheckDospem->prodi_nama, $user->user_verify_token, $passwordTemp));

            $success++;
        }// end for

        if(count($errorrow)>0)
        {
            $successmessage = 'Import berhasil sebanyak '.$success.' mahasiswa, baris yang dilewati:<br>';
            for($i=0; $i<count($errorrow); $i++) $successmessage = $successmessage.$errorrow[$i].",<br>";
        }
        else
        {
            $successmessage = 'Import berhasil sebanyak '.$success.' mahasiswa tanpa ada baris yang dilewati.';
        }

        Session::flash('success', $successmessage);
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_id', $request->id )->first();
        if(empty($mahasiswa)) abort(404);
        
        try
        {
            Mahasiswa::where('mahasiswa_id',$request->id)->delete();
            User::where('user_email',$mahasiswa->mahasiswa_user_email)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Hapus mahasiswa ('.$mahasiswa->mahasiswa_nim.') '.$mahasiswa->mahasiswa_nama.' berhasil');
        return redirect()->back();
    }

    public function reverify(Request $request)
    {
        if(empty($request->id)) abort(404);
        
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);
        
        try
        {
            $mahasiswa = Mahasiswa::where('mahasiswa_id', $request->id)->first();

            $passwordTemp = Str::random(6);
            $verify_token = Str::random(32);
            User::where('user_email', $mahasiswa->mahasiswa_user_email)
                ->update([
                    'user_password'         => Hash::make($passwordTemp),
                    'user_verify_token'     => $verify_token,
                    'user_email_verified_at'=> null,
                    'user_status'           => '1',
                ]);
                
            // send email verification
            $params = new \stdClass();
            $params->mahasiswa_user_email  = $mahasiswa->mahasiswa_user_email;
            $params->mahasiswa_nim         = $mahasiswa->mahasiswa_nim;
            $params->mahasiswa_nama        = $mahasiswa->mahasiswa_nama;

            $prodi = Prodi::join('dospems', 'dospems.dospem_prodi_id', '=', 'prodis.prodi_id')
                            ->where('dospem_id', $mahasiswa->mahasiswa_dospem_id)->first();
            Mail::to($mahasiswa->mahasiswa_user_email)->send(new NewMahasiswaEmail($params, $univ->univ_nama, $prodi->prodi_nama, $verify_token, $passwordTemp));

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'E-mail berhasil dikirim. Mahasiswa harus klik verifikasi pada email untuk dapat menggunakan akunnya kembali.');
        return redirect()->back();
    }
    
    public function detailjson(Request $request)
    {
        $json = [];

        if(!empty($request->query('id'))){
            // DB::enableQueryLog();
            $json = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->where('mahasiswa_id', $request->query('id'))
                        ->first();
            // dd(DB::getQueryLog());
        }
        echo json_encode($json);
    }
}
