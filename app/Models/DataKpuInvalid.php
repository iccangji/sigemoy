<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKpuInvalid extends Model
{
    protected $table = 'data_kpu_invalid';
    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'hub_keluarga',
        'tps',
        'kelurahan',
        'kecamatan',
        'nama_pj',
        'no_hp_pj',
    ];
}
