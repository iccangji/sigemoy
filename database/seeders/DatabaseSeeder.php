<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PemilihSeeder;
use Database\Seeders\DataKpuSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PemilihSeeder::class,
            UserSeeder::class,
            DataKpuSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class
        ]);
    }
}
