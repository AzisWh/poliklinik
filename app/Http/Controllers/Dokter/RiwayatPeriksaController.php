<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\TablePeriksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        $dokterId = Auth::guard('dokter')->user()->id;
        
        $riwayatPeriksa = TablePeriksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa', 'detailPeriksa.obat'])
        ->whereHas('daftarPoli.jadwalPeriksa', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })
        ->orderBy('tgl_periksa', 'asc')
        ->get();

        // $listPasien = DB::table('users')
        // ->join('daftar_poli', 'users.id', '=', 'daftar_poli.id_pasien')
        // ->join('table_jadwal_periksa', 'daftar_poli.id_jadwal', '=', 'table_jadwal_periksa.id')
        // ->where('table_jadwal_periksa.id_dokter', $dokterId)
        // ->select('users.*')
        // ->get();

        // $sumPasien = $listPasien->count();


        return view('dokter.riwayat', compact('riwayatPeriksa'));
    }
}
