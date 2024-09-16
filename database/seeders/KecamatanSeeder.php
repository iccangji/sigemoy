<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kecamatan::create([
            'id' => 1,
            'nama' => 'Kambu',
        ]);
        Kecamatan::create([
            'id' => 2,
            'nama' => 'Baruga',
        ]);
        Kecamatan::create([
            'id' => '3',
            'nama' => 'Poasia',
        ]);
        Kecamatan::create([
            'id' => '4',
            'nama' => 'Kendari',
        ]);
         Kecamatan::create([
             'id' => '5',
             'nama' => 'Kendari Barat',
         ]);
         Kecamatan::create([
             'id' => '6',
             'nama' => 'Nambo',
         ]);
         Kecamatan::create([
             'id' => '7',
             'nama' => 'Puuwatu',
         ]);
         Kecamatan::create([
             'id' => '8',
             'nama' => 'Kadia',
         ]);
         Kecamatan::create([
             'id' => '9',
             'nama' => 'Wua Wua',
         ]);
         Kecamatan::create([
             'id' => '10',
             'nama' => 'Abeli',
         ]);
         Kecamatan::create([
             'id' => '11',
             'nama' => 'Mandonga',
         ]);
    }
}
