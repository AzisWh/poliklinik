<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablePeriksa extends Model
{
    use HasFactory;

    protected $table = 'table_periksa';

    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatatn',
        'biaya_periksa',
    ];

    public function daftarPoli()
    {
        return $this->belongsTo(PendaftaranPoli::class, 'id_daftar_poli');
    }

    public function detailPeriksa()
    {
        return $this->hasMany(TableDetailPeriksa::class, 'id_periksa');
    }
}
