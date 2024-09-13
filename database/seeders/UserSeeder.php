<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat user dengan role Admin
        User::factory()->create([
            'name' => 'Admin User',
            'role' => UserRole::Admin->value,
            'password' => Hash::make('adminpassword'), // Password untuk admin
        ]);

        // Membuat user dengan role Input
        User::factory()->create([
            'name' => 'Input User',
            'role' => UserRole::Input->value,
            'password' => Hash::make('inputpassword'), // Password untuk input
        ]);

        // Membuat user dengan role Viewer
        User::factory()->create([
            'name' => 'Viewer User',
            'role' => UserRole::Viewer->value,
            'password' => Hash::make('viewerpassword'), // Password untuk viewer
        ]);

        // Membuat 10 user acak dengan role berbeda
        User::factory()->count(10)->create([
            'password' => Hash::make('password'), // Password default untuk user acak
        ]);
    }
}
