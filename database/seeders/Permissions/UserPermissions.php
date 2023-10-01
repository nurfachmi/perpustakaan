<?php

namespace Database\Seeders\Permissions;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resource = 'users';
        $roles = [
            $resource . '.index',
            $resource . '.create',
            $resource . '.store',
            $resource . '.show',
            $resource . '.edit',
            $resource . '.update',
            $resource . '.destroy',
        ];

        $permissionsByRole = [
            User::ROLE_ADMINISTRATOR => $roles,
        ];

        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
        ->map(fn ($name) => DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']))
        ->toArray();

        $permissionIdsByRole = [
            User::ROLE_ADMINISTRATOR => $insertPermissions(User::ROLE_ADMINISTRATOR),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::whereName($role)->first();

            DB::table('role_has_permissions')
            ->insert(
                collect($permissionIds)->map(fn ($id) => [
                    'role_id' => $role->id,
                    'permission_id' => $id
                ])->toArray()
            );
        }
    }
}
