<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{
    protected $table = 'pemilih';

    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'hub_keluarga',
        'tps',
        'kelurahan',
        'nama_pj',
    ];
}