<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKpu extends Model
{
    use HasFactory;
    protected $table = 'data_kpu';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'usia',
        'alamat',
        'tps',
        'kelurahan',
    ];

}
