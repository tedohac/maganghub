<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Perusahaan;
use Artisan;
use Auth;
use Session;
use Storage;
use Validator;

class ProfilPerusahaanController extends Controller
{
    public function detail($id)
    {
        $perusahaan = Perusahaan::leftJoin('cities', 'cities.city_id', '=', 'perusahaans.perusahaan_city_id')
                                ->where('perusahaan_id', $id )->first();
        if(empty($perusahaan)) abort(404);

    	return view('perusahaan.detail', [
            'perusahaan' => $perusahaan
        ]);
    }
}
