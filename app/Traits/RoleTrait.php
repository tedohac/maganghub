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
        if(Auth::user()->user_status == 1) return redirect()->route('verifyneeded');
        elseif(Auth::user()->user_role == 'admin kampus')
        {
            $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
            return redirect('kampus/detail/'.$univ->univ_id);
        }
        elseif(Auth::user()->user_role == 'dospem')
        {
            return redirect()->route('kampus.list');
        }
        echo Auth::user()->role."asd";
        // abort(404);
    }
}

  