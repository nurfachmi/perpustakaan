<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class WebPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();
        $permissionRegistered = Permission::where('name', $routeName)->first();
        if ($permissionRegistered) {
            $user = Auth::user();
            if (!$user) abort(403);
            $roleId = $user->roles->pluck('id')->first();
            $rolePermissions = DB::table('role_has_permissions')->where('role_id', $roleId)
                ->where('permission_id', $permissionRegistered->id)
                ->first();

            $userPermission = DB::table('model_has_permissions')->where('model_id', $user->id)
                ->where('model_type', 'App\Models\User')
                ->where('permission_id', $permissionRegistered->id)
                ->first();

            if (!$userPermission and !$rolePermissions) abort(404);
        }
        return $next($request);
    }
}
