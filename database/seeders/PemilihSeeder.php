<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemilihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pemilih::factory()->create([
            'nama' => 'tes',
            'nik' => 'tes',
            'no_hp' => 'tes',
            'hub_keluarga' => 'tes',
            'tps' => 'tes',
            'kelurahan' => 'tes',
            'nama_pj' => 'tes'
        ]);
    }
}
