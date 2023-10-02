<?php

namespace Database\Seeders\Permissions;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class BorrowPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            Role::firstWhere('name', User::ROLE_ADMINISTRATOR),
            Role::firstWhere('name', User::ROLE_PUSTAKAWAN)
        ];

        $permissions = [
            // Borrow
            'borrows.index', 'borrows.create', 'borrows.store',
            'borrows.show', 'borrows.edit', 'borrows.update', 'borrows.destroy',
            // Borrow Book
            'borrows.borrow_books.index', 'borrows.borrow_books.create', 'borrows.borrow_books.store',
            'borrows.borrow_books.show', 'borrows.borrow_books.edit', 'borrows.borrow_books.update', 'borrows.borrow_books.destroy',
        ];

        $permissionIds = collect($permissions)
            ->map(fn ($name) => DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']))
            ->toArray();

        foreach ($roles as $role) {
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
