<?php

namespace App\Imports;

use App\Models\DataKpu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DataKpuImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        if (is_null($row[0])) {
            return null;
        }
        return new DataKpu([
            'nama'     => $row[1],
            'jenis_kelamin' => $row[3],
            'usia' => $row[4],
            'alamat' => $row[5],
            'tps' => $row[10],
            'kelurahan' => $row[9],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
