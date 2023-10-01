<?php

namespace Database\Seeders;

use Database\Seeders\Permissions\MemberPermissions;
use Database\Seeders\Permissions\ModulePermissions;
use Database\Seeders\Permissions\UserPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->call([
            UserPermissions::class,
            ModulePermissions::class,
            MemberPermissions::class,
        ]);
    }
}
