<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\TablePeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::guard('pasien')->user(); 
        
        $daftarPoli = DB::table('daftar_poli')
        ->join('table_jadwal_periksa', 'daftar_poli.id_jadwal', '=', 'table_jadwal_periksa.id')
        ->join('users', 'daftar_poli.id_pasien', '=', 'users.id')
        ->where('daftar_poli.id_pasien', $user->id)
        ->select('daftar_poli.*', 'table_jadwal_periksa.*', 'users.*')
        ->get();

        $periksa = DB::table('table_periksa')
        ->join('daftar_poli', 'table_periksa.id_daftar_poli', '=', 'daftar_poli.id')
        ->leftJoin('table_detail_periksa', 'table_periksa.id', '=', 'table_detail_periksa.id_periksa')
        ->where('daftar_poli.id_pasien', $user->id)
        ->select('table_periksa.*', 'table_detail_periksa.*', 'daftar_poli.id as daftar_poli_id')
        ->get();

        $status = [];
        $detailPeriksa = [];
        $nomor_antrian = [];

        foreach ($daftarPoli as $item) {
            $id = $item->id;
            $nomor_antrian[$id] = $item->no_antrian;

            $periksaData = $periksa->firstWhere('id_daftar_poli', $id);

            if ($periksaData) {
                $status[$id] = 'Sudah diperiksa';
                $detailPeriksa[$id] = $periksaData;
            } else {
                $status[$id] = 'Menunggu diperiksa';
                $detailPeriksa[$id] = null;
            }
        }

        return view('pasien.riwayat', compact('daftarPoli', 'status', 'nomor_antrian', 'detailPeriksa'));
    }

}
