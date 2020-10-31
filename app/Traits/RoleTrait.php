<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Univ;
use Auth;

trait RoleTrait {
    /**

     * @param Request $request

     * @return $this|false|string

     */

    public function redirectRole()
    {
        if(Auth::user()->status == 1) return redirect()->route('verifyneeded');
        elseif(Auth::user()->role == 'admin kampus')
        {
            $univ = Univ::where('email', Auth::user()->email )->first();
            return redirect('kampus/detail/'.$univ->id);
        }
        echo Auth::user()->role."asd";
        // abort(404);
    }
}

  