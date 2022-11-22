<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Admin;
class MyPostAccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userId)
    {
        if(Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN])){
            return $next($request);
        }
        // dd($userId);
        if(Admin::user()->isRole(ROLE_USER) && Admin::user()->id == $userId){
            return $next($request);
        }

        return response()->view('warnings.notPermissionToAccessPage');
    }
}
