<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Univ;
use App\Prodi;
use App\Dospem;
use Validator;
use Session;
use Auth;

class DospemController extends Controller
{
    public function manage()
    {
        if(Auth::user()->role != 'admin kampus') return abort(404);

        $univ = Univ::where('email', Auth::user()->email )->first();
        if(empty($univ)) return abort(404);

        $dospem = Prodi::where('univ_id', $univ->id)->get();
        $dospem = Dospem::join('prodis', 'prodis.id', '=', 'dospems.prodi_id')
                        ->where('prodis.univ_id', $univ->id)
                        ->get();

    	return view('kampus.dospem', [
            'univ' => $univ,
            'prodis' => $prodis
        ]);
    }
}
