<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Emon',
            'email' => 'adminemon@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // ganti dengan password aman
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

                DB::table('users')->insert([
            'name' => 'Admin Rojak',
            'email' => 'adminrojak@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

            DB::table('users')->insert([
            'name' => 'Admin Adi',
            'email' => 'adminadi@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'dapa',
            'email' => 'dapa@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('dapa123'),
            'role' => 'user',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
