<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableDetailPeriksa extends Model
{
    use HasFactory;

    protected $table = 'table_detail_periksa';

    protected $fillable = [
        'id_periksa',
        'id_obat',
    ];

    public function periksa()
    {
        return $this->belongsTo(TablePeriksa::class, 'id_periksa');
    }

    public function obat()
    {
        return $this->belongsTo(ObatModel::class, 'id_obat');
    }
}
