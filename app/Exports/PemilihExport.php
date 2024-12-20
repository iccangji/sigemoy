<?php

namespace App\Exports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PemilihExport implements WithColumnFormatting, FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Pemilih::all(
            [
                'nama',
                'nik',
                'no_hp',
                'hub_keluarga',
                'tps',
                'kelurahan',
                'kecamatan',
                'nama_pj',
                'no_hp_pj'
            ]
        )->map(function ($item) {
            $item->nik = "'$item->nik";
            return $item;
        });;
    }

    public function headings(): array
    {
        // Tentukan nama header untuk setiap kolom
        return [
            'Nama',
            'NIK',
            'No HP',
            'Hubungan Keluarga',
            'TPS',
            'Kelurahan',
            'Kecamatan',
            'Nama Penanggung Jawab',
            'No HP Penanggung Jawab'
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Mengatur kolom 'C' (Phone Number) sebagai angka
            'C' => NumberFormat::FORMAT_TEXT, // Mengatur kolom 'C' (Phone Number) sebagai angka
        ];
    }
}
