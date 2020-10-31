<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use DB;

class CityController extends Controller
{
    public function autocom(Request $request)
    {
        $json = [];

        if(!empty($request->query('q'))){
            // DB::enableQueryLog();
            $json = City::where('city_nama', 'LIKE', '%'.$request->query('q').'%')
                        ->select('id as id', 'city_nama as text')
                        ->get()->take(5);
            // dd(DB::getQueryLog());
        }
        echo json_encode($json);
    }
}
