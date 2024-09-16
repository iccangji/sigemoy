<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    public $timestamps = false;
    // Kolom yang bisa diisi (mass-assignable)
    protected $fillable = ['nama', 'kecamatan_id'];

    // Relasi Many to One dengan Kecamatan
    public function kecamatan()
    {
        return $this->hasMany(Kelurahan::class);
    }
}
