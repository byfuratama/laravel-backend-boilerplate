<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Jsend;

class RoleAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $my_role = $request->user()->role;
        if ($roles && !(in_array($my_role,$roles) || $my_role == 'superadmin')) {
            return Jsend::fail('Unauthorized Access');
        }
        return $next($request);
    }
}
