<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGanda extends Model
{
    protected $table = 'data_ganda';
    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'hub_keluarga',
        'tps',
        'kelurahan',
        'kecamatan',
        'nama_pj',
        'created_by',
    ];
}
