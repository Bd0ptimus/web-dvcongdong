<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Admin;
use App\Models\post;
class EditPostAccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $postId)
    {
        if(Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN])){
            return $next($request);
        }

        if(Admin::user()->isRole(ROLE_USER) && post::find($postId)->user_id == Admin::user()->id){
            return $next($request);
        }
        return response()->view('warnings.notPermissionToAccessPage');

    }
}
