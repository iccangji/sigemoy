<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'user' => 'admin',
            'password' => Hash::make('123'),
            'level' => 'admin',
        ]);

        DB::table('users')->insert([
            'user' => 'viewer',
            'password' => Hash::make('123'),
            'level' => 'viewer',
        ]);

        DB::table('users')->insert([
            'user' => 'penginput',
            'password' => Hash::make('123'),
            'level' => 'penginput',
        ]);
    }
}
