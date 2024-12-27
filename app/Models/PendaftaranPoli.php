<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPoli extends Model
{
    use HasFactory;

    protected $table = 'daftar_poli';

    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }


    public function jadwalPeriksa()
    {
        return $this->belongsTo(ModelJadwalPeriksa::class, 'id_jadwal');
    }
    
}
