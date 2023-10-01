<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PustakawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_pustakawan = Role::updateOrCreate(['name' => User::ROLE_PUSTAKAWAN]);

        $pustakawan = User::updateOrCreate(
            [
                'name' => 'Pustakawan',
                'email' => 'pustakawan@nurfachmi.com',
            ],
            [
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]
        )->assignRole($role_pustakawan);

        $card = Card::updateOrCreate(
            [
                'number' => str($pustakawan->getKey())->padLeft(5, '0')
            ],
            [
                'start_date' => now(),
                'end_date' => now()->addYear()
            ]
        );
        $card->user()->associate($pustakawan);
        $card->save();
    }
}
