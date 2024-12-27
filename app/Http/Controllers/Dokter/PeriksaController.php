<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\ObatModel;
use App\Models\TableDetailPeriksa;
use App\Models\TablePeriksa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PeriksaController extends Controller
{
    public function index()
    {
        $dokter = Auth::guard('dokter')->user();
        $obats = ObatModel::all();
        $daftarPoli = DaftarPoli::with(['pasien', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('id_dokter', $dokter->id);
            })
            ->orderBy('no_antrian', 'asc')
            ->whereNull('deleted_at')
            ->get();

        return view('dokter.periksa', compact('daftarPoli', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required',
            'catatan' => 'required',
            'obat' => 'required|array',
        ]);

        try {
            $totalBiayaObat = ObatModel::whereIn('id', $request->obat)->sum('harga');

            $periksa = TablePeriksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => Carbon::now(),
                'catatatn' => $request->catatan,
                'biaya_periksa' => 150000 + $totalBiayaObat,
            ]);

            foreach ($request->obat as $obatId) {
                TableDetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }

            $daftarPoli = DaftarPoli::find($request->id_daftar_poli);
            $daftarPoli->delete();

            Alert::success('Berhasil!', 'Pasien sudah diperiksa.');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->route('dokter.riwayat');
    }
}
