<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Pemilih;
use App\Models\DataGanda;
use App\Models\DataKpuInvalid;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekapExport implements WithColumnFormatting, FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $search;
    public function __construct($search)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $items = Pemilih::where('nama_pj', 'like', "%$this->search%")
            ->orderBy('updated_at', 'desc')->get(
                [
                    'nama',
                    'nama_pj',
                    'nik',
                    'no_hp',
                    'hub_keluarga',
                    'tps',
                    'kelurahan',
                    'kecamatan',
                ]
            )->map(function ($item) {
                $item->status = 'Valid';
                $item->nik = "'$item->nik";
                return $item;
            });
        $itemsGanda = DataGanda::where('report', 'like', "%$this->search%")
            ->orderBy('updated_at', 'desc')->get(
                [
                    'nama',
                    'report',
                    'nik',
                    'no_hp',
                    'hub_keluarga',
                    'tps',
                    'kelurahan',
                    'kecamatan',
                ]
            )->map(function ($item) {
                $item->status = 'Ganda';
                $item->nik = "'$item->nik";
                $str = str_replace(
                    'Terdapat irisan data antara penanggung jawab atas nama',
                    '',
                    $item->report,
                );
                $str = str_replace('dan', '/', $str);
                $str = preg_replace('/\([^)]*\)/', '', $str);
                $item->report = $str;
                return $item;
            });
        $itemsInvalid = DataKpuInvalid::where('nama_pj', 'like', "%$this->search%")
            ->orderBy('updated_at', 'desc')->get(
                [
                    'nama',
                    'nama_pj',
                    'nik',
                    'no_hp',
                    'hub_keluarga',
                    'tps',
                    'kelurahan',
                    'kecamatan',
                ]
            )->map(function ($item) {
                $item->status = 'Tidak Valid';
                $item->nik = "'$item->nik";
                return $item;
            });
        return $items->concat($itemsGanda)->concat($itemsInvalid);
    }
    public function headings(): array
    {
        // Tentukan nama header untuk setiap kolom
        return [
            'Nama',
            'Nama PJ',
            'NIK',
            'No HP',
            'Hubungan Keluarga',
            'TPS',
            'Kelurahan',
            'Kecamatan',
            'Status',
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
