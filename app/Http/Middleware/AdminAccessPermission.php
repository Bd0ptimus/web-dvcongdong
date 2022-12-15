<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Admin;
class AdminAccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Admin::user() !==null && !Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN]) ||(Admin::user() ==null)){
            return response()->view('warnings.notPermissionToAccessPage');
        }
        return $next($request);
    }
}
