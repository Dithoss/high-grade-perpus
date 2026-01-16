<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'user'];

        foreach ($roles as $roleName) {
            $user = User::firstOrCreate(
                ['email' => $roleName . '@gmail.com'],
                [
                    'id' => Str::uuid(),
                    'name' => ucfirst($roleName),
                    'password' => Hash::make('1234'),
                ]
            );

            if (! $user->hasRole($roleName)) {
                $user->assignRole($roleName);
            }
        }
    }
}


