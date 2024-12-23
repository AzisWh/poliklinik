<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaController extends Controller
{
    public function index()
    {
        $dokter = Auth::guard('dokter')->user();

        $daftarPoli = DaftarPoli::with(['pasien', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('id_dokter', $dokter->id);
            })
            ->orderBy('no_antrian', 'asc')
            ->get();

        return view('dokter.periksa', compact('daftarPoli'));
    }
}
