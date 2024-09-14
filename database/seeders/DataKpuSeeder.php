<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKpuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_kpu')->insert([
            'nama' => 'tes',
            'jenis_kelamin' => 'L',
            'usia' => 20,
            'alamat' => 'tes',
            'tps' => '001',
            'kelurahan' => 'Kambu',
        ]);
    }
}
