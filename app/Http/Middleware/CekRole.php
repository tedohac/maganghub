<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role_names)
    {
        if (User::hasRoles($role_names))
        {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Silahkan login untuk melanjutkan');
    }
}
