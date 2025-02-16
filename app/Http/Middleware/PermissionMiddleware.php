<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AdminUser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission, $feature): Response
    {
        if(!Permission::hasPermission(Auth::user(), $permission, $feature)) {
            return redirect()->back();
        }
        return $next($request);
    }
}
