<?php

namespace App\Imports;

use App\Http\Controllers\PemilihController;
use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PemilihImport implements WithMultipleSheets
{
    protected $user;

    // Constructor untuk menerima user dari controller
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function sheets(): array
    {
        return [
            0 => new PemilihSheetImport($this->user),
        ];
    }
}
