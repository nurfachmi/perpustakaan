<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Role $role)
    {
        $data['title'] = 'Permissions for ' . $role->name;
        $data['role'] = $role;
        $data['permissions'] = Permission::pluck('name', 'id');
        return view('pages.permission.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Role $role)
    {
        try {
            DB::beginTransaction();
            foreach($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return to_route('permissions.index', $role->getKey())->withToastError('Ups, ' . $th->getMessage());
        }

        return to_route('permissions.index', $role->getKey())->withToastSuccess('Berhasil menambahkan permission');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        try {
            DB::beginTransaction();
            foreach ($request->permissions as $permission) {
                $role->revokePermissionTo($permission);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return to_route('permissions.index', $role->getKey())->withToastError('Ups, ' . $th->getMessage());
        }

        return to_route('permissions.index', $role->getKey())->withToastSuccess('Berhasil mengurangi permission');
    }
}
