<?php

namespace Database\Factories;

use App\Models\Pemilih;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemilih>
 */
class PemilihFactory extends Factory
{

    protected $model = Pemilih::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'nik' => '001',
            'no_hp' => '082134567890',
            'hub_keluarga' => $this->faker->randomElement(['Saudara Kandung', 'Mertua', 'Ipar', 'Suami/Istri', 'Anak', 'Ponakan']),
            'tps' => $this->faker->randomElement(['001', '002', '003', '004']),
            'kelurahan' => $this->faker->randomElement(['Kambu', 'Sambuli', 'Pondambea', 'Abeli', 'Bende']),
            'kecamatan' => $this->faker->randomElement([
                'Kambu',
                'Baruga',
                'Abeli',
                'Poasia',
                'Mandonga',
                'Kendari',
                'Kendari Barat',
                'Wua Wua',
                'Puuwatu',
                'Kadia',
                'Nambo'
            ]),
            'nama_pj' => $this->faker->name,
            'no_hp_pj' => '082134567890',
            'created_by' => $this->faker->name
        ];
    }
}
