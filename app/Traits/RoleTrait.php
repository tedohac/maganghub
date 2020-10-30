<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Auth;

trait RoleTrait {
    /**

     * @param Request $request

     * @return $this|false|string

     */

    public function redirectRole()
    {
        if(Auth::user()->status == 1) return redirect()->route('verifyneeded');

        if(Auth::user()->role == 'admin kampus') return redirect()->route('kampus.manage');
        echo Auth::user()->role."asd";
        // abort(404);
    }
}

  