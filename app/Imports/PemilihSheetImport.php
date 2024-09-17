<?php

namespace App\Imports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PemilihSheetImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    protected $user;

    // Constructor untuk menerima user dari controller
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function model(array $row)
    {
        if (is_null($row[0])) {
            return null;
        }
        return new Pemilih([
            'nama'     => $row[0],
            'nik'    => $row[1],
            'no_hp' => $row[2],
            'hub_keluarga' => $row[3],
            'kecamatan' => $row[4],
            'kelurahan' => $row[5],
            'tps' => $row[6],
            'nama_pj' => $row[7],
            'created_by' => $this->user,
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
