<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\Csv\Reader;
use App\Mail\NewDospemEmail;
use App\Rules\NikDospemRule;
use App\Rules\NikDospemUpdateRule;
use App\Univ;
use App\Prodi;
use App\User;
use App\Dospem;
use Validator;
use Session;
use Storage;
use Artisan;
use Hash;
use Mail;
use Auth;
use DB;

class ManageDospemController extends Controller
{
    public function manage()
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $dospems = Dospem::join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('users', 'users.user_email', '=', 'dospems.dospem_user_email')
                        ->where('prodis.prodi_univ_id', $univ->univ_id)
                        ->select('*', DB::raw('(select count(mahasiswa_id) from mahasiswas where mahasiswa_dospem_id=dospem_id) as total_mahasiswa'))
                        ->get();

    	return view('kampus.manage_dospem', [
            'univ' => $univ,
            'dospems' => $dospems
        ]);
    }
    
    public function importform()
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

    	return view('kampus.import_dospem', [
            'univ' => $univ
        ]);
    }
    
    public function save(Request $request)
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $rules = [
            'dospem_nik'        => ['required', new NikDospemRule($univ->univ_id)],
            'dospem_nama'       => 'required',
            'dospem_prodi_id'   => 'required|exists:prodis,prodi_id,prodi_univ_id,'.$univ->univ_id,
            'dospem_user_email' => 'required|email|unique:users,user_email',
        ];
 
        $messages = [
            'dospem_nik.required'       => 'Masukan NIK Dosen Pembimbing',
            'dospem_nama.required'      => 'Masukan nama Dosen Pembimbing',
            'dospem_prodi_id.required'  => 'Pilih PRODI Dosen Pembimbing',
            'dospem_prodi_id.exists'    => 'PRODI Tidak Terdaftar',
            'dospem_user_email.required'=> 'Masukan e-mail Dosen Pembimbing',
            'dospem_user_email.email'   => 'Format e-mail tidak valid',
            'dospem_user_email.unique'  => 'E-mail sudah terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $passwordTemp = Str::random(6);

        $user = new User;
        $user->user_email        = strtolower($request->dospem_user_email);
        $user->user_role         = 'dospem';
        $user->user_status       = '1';
        $user->user_password     = Hash::make($passwordTemp);
        $user->user_verify_token = Str::random(32);
        $simpanuser = $user->save();

        $dospem = new Dospem;
        $dospem->dospem_user_email  = strtolower($request->dospem_user_email);
        $dospem->dospem_prodi_id    = $request->dospem_prodi_id;
        $dospem->dospem_nik         = $request->dospem_nik;
        $dospem->dospem_nama        = $request->dospem_nama;
        $simpandospem = $dospem->save();

        if($simpanuser && $simpandospem)
        {
            $prodi = Prodi::where('prodi_id', $request->dospem_prodi_id)->first();
            Mail::to($request->dospem_user_email)->send(new NewDospemEmail($request, $univ->univ_nama, $prodi->prodi_nama, $user->user_verify_token, $passwordTemp));

            Session::flash('success', 'Tambah program studi berhasil');
            return redirect()->back();
        } else {
            Session::flash('error', 'Tambah program studi gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        if(empty($request->edit_id)) abort(404);

        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        // get dospem's original email
        $dospem = Dospem::where('dospem_id', $request->edit_id )->first();
        if(empty($dospem)) abort(404);

        $rules = [
            'dospem_nik'        => ['required', new NikDospemUpdateRule($univ->univ_id, $request->edit_id)],
            'dospem_nama'       => 'required',
            'dospem_prodi_id'   => 'required|exists:prodis,prodi_id,prodi_univ_id,'.$univ->univ_id,
            'dospem_user_email' => 'required|email|unique:users,user_email,'.$dospem->dospem_user_email.',user_email',
        ];

        $messages = [
            'dospem_nik.required'       => 'Masukan NIK Dosen Pembimbing',
            'dospem_nama.required'      => 'Masukan nama Dosen Pembimbing',
            'dospem_prodi_id.required'  => 'Pilih PRODI Dosen Pembimbing',
            'dospem_prodi_id.exists'    => 'PRODI Tidak Terdaftar',
            'dospem_user_email.required'=> 'Masukan e-mail Dosen Pembimbing',
            'dospem_user_email.email'   => 'Format e-mail tidak valid',
            'dospem_user_email.unique'  => 'E-mail sudah terdaftar di MagangHub',
        ];
 
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        try
        {
            Dospem::where('dospem_id',$request->edit_id)
                ->update([
                    'dospem_nik'        => $request->dospem_nik,
                    'dospem_nama'       => $request->dospem_nama,
                    'dospem_prodi_id'   => $request->dospem_prodi_id,
                ]);

            // if email changed
            if($request->dospem_user_email!=$dospem->dospem_user_email)
            {
                Dospem::where('dospem_id',$request->edit_id)
                    ->update([
                        'dospem_user_email' => null,
                    ]);

                $passwordTemp = Str::random(6);
                $verify_token = Str::random(32);
                User::where('user_email', $dospem->dospem_user_email)
                    ->update([
                        'user_email'        => $request->dospem_user_email,
                        'user_password'     => Hash::make($passwordTemp),
                        'user_verify_token' => $verify_token,
                        'user_status'       => '1',
                    ]);

                Dospem::where('dospem_id',$request->edit_id)
                    ->update([
                        'dospem_user_email' => $request->dospem_user_email,
                    ]);

                // send email verification
                $params = new \stdClass();
                $params->dospem_user_email  = $request->dospem_user_email;
                $params->dospem_nik         = $request->dospem_nik;
                $params->dospem_nama        = $request->dospem_nama;

                $prodi = Prodi::where('prodi_id', $request->dospem_prodi_id)->first();
                Mail::to($request->dospem_user_email)->send(new NewDospemEmail($params, $univ->univ_nama, $prodi->prodi_nama, $verify_token, $passwordTemp));

                Session::flash('success', 'Edit dosen pembimbing berhasil, dosen pembimbing memerlukan verifikasi email ulang karena e-mail telah berubah.');
                return redirect()->back();
            }
            else {
                Session::flash('success', 'Edit dosen pembimbing berhasil.');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub '.$e);
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
 
        $filename = 'temp_import_dospem.csv';

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
                if(count($row)!=4) {
                    Session::flash('error', 'Jumlah kolom tidak sesuai template');
                    return redirect()->back();
                }
                
                if($row[0]!='NIK' || $row[1]!='Nama Dosen' || $row[2]!='ID Prodi' || $row[3]!='E-Mail Dosen') {
                    Session::flash('error', 'Kolom tidak sesuai template');
                    return redirect()->back();
                }

                continue;
            }

            // all column not nullable
            if($row[0]=='' || $row[1]=='' || $row[2]=='' || $row[3]=='') {
                array_push($errorrow,$rownum);
                continue;
            }

            // validate email format
            if (!filter_var($row[3], FILTER_VALIDATE_EMAIL)) {
                array_push($errorrow,$rownum);
                continue;
            }

            // unique NIK
            $datacheck = Dospem::where('dospem_nik', $row[0])->first();
            if(!empty($datacheck)){
                array_push($errorrow,$rownum);
                continue;
            }

            // check ID Prodi
            $datacheck = Prodi::where('prodi_id', $row[2])->first();
            if(empty($datacheck)){
                array_push($errorrow,$rownum);
                continue;
            }

            // unique email
            $datacheck = User::where('user_email', $row[3])->first();
            if(!empty($datacheck)){
                array_push($errorrow,$rownum);
                continue;
            }
            
            $passwordTemp = Str::random(6);

            $user = new User;
            $user->user_email        = strtolower($row[3]);
            $user->user_role         = 'dospem';
            $user->user_status       = '1';
            $user->user_password     = Hash::make($passwordTemp);
            $user->user_verify_token = Str::random(32);
            $simpanuser = $user->save();

            $dospem = new Dospem;
            $dospem->dospem_user_email  = strtolower($row[3]);
            $dospem->dospem_prodi_id    = $row[2];
            $dospem->dospem_nik         = $row[0];
            $dospem->dospem_nama        = $row[1];
            $simpandospem = $dospem->save();

            if(!$simpanuser || !$simpandospem){
                Session::flash('error', 'Import data DOSPEM gagal! Mohon hubungi admin MagangHub');
                return redirect()->back();
            }
            
            // send email verification
            $params = new \stdClass();
            $params->dospem_user_email  = strtolower($row[3]);
            $params->dospem_nik         = $row[0];
            $params->dospem_nama        = $row[1];

            $prodi = Prodi::where('prodi_id', $row[2])->first();
            Mail::to(strtolower($row[3]))->send(new NewDospemEmail($params, $univ->univ_nama, $prodi->prodi_nama, $user->user_verify_token, $passwordTemp));

            $success++;
        }// end for

        if(count($errorrow)>0)
        {
            $successmessage = 'Import berhasil sebanyak '.$success.' DOSPEM, baris yang dilewati: ';
            for($i=0; $i<count($errorrow); $i++) $successmessage = $successmessage.$errorrow[$i].", ";
        }
        else
        {
            $successmessage = 'Import berhasil sebanyak '.$success.' DOSPEM tanpa ada baris yang dilewati.';
        }

        Session::flash('success', $successmessage);
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $dospem = Dospem::where('dospem_id', $request->id )->first();
        if(empty($dospem)) abort(404);
        
        try
        {
            Dospem::where('dospem_id',$request->id)->delete();
            User::where('user_email',$dospem->dospem_user_email)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Hapus dosen pembimbing ('.$dospem->dospem_nik.') '.$dospem->dospem_nama.' berhasil');
        return redirect()->back();
    }

    public function reverify(Request $request)
    {
        if(empty($request->id)) abort(404);
        
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        try
        {
            $dospem = Dospem::where('dospem_id', $request->id)->first();

            $passwordTemp = Str::random(6);
            $verify_token = Str::random(32);
            User::where('user_email', $dospem->dospem_user_email)
                ->update([
                    'user_password'     => Hash::make($passwordTemp),
                    'user_verify_token' => $verify_token,
                    'user_status'       => '1',
                ]);

            // send email verification
            $params = new \stdClass();
            $params->dospem_user_email  = $dospem->dospem_user_email;
            $params->dospem_nik         = $dospem->dospem_nik;
            $params->dospem_nama        = $dospem->dospem_nama;

            $prodi = Prodi::where('prodi_id', $dospem->dospem_prodi_id)->first();
            Mail::to($dospem->dospem_user_email)->send(new NewDospemEmail($params, $univ->univ_nama, $prodi->prodi_nama, $verify_token, $passwordTemp));
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'E-mail berhasil dikirim. Dosen harus klik verifikasi pada email untuk dapat menggunakan akunnya kembali.');
        return redirect()->back();
    }
    
    public function detailjson(Request $request)
    {
        $json = [];

        if(!empty($request->query('id'))){
            // DB::enableQueryLog();
            $json = Dospem::join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->where('dospem_id', $request->query('id'))
                        ->first();
            // dd(DB::getQueryLog());
        }
        echo json_encode($json);
    }

    public function autocom(Request $request)
    {
        $json = [];
        if(!empty($request->query('q')) && !empty($request->query('univid'))){
            // DB::enableQueryLog();
            $json = Dospem::join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->where('prodis.prodi_univ_id', $request->query('univid'))
                        ->where('dospem_nama', 'LIKE', '%'.$request->query('q').'%')
                        ->select(DB::raw('CONCAT("[", prodis.prodi_nama, "] (", dospem_nik , ") ", dospem_nama) as text'), 'dospem_id as id')
                        ->get()->take(5);
            // dd(DB::getQueryLog());
        }
        echo json_encode($json);
    }
}
