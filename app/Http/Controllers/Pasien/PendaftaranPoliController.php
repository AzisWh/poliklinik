<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\ModelJadwalPeriksa;
use App\Models\PoliModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class PendaftaranPoliController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('pasien')->user();
        if (!$user) {
            dd('User tidak ditemukan. Pastikan user sudah login.');
        }

        $poli = PoliModel::all();

        $jadwal = [];
        $poliId = $request->id_poli;
        if ($request->has('id_poli') && $poliId) {
            $poliSelected = PoliModel::find($poliId);
            if ($poliSelected) {
                $jadwal = ModelJadwalPeriksa::with(['dokter.poli'])
                    ->whereHas('dokter', function ($query) use ($poliId) {
                        $query->where('id_poli', $poliId);
                    })
                    ->where('status', 'aktif')
                    ->get();
            }
        }

        return view('pasien.poli', compact('poli', 'user', 'jadwal'));
    }

    // public function getJadwal($id)
    // {
    //     $poli = PoliModel::find($id);

    //     if (!$poli) {
    //         return response()->json([], 404);
    //     }

    //     $dokters = $poli->doctors;

    //     $jadwal = ModelJadwalPeriksa::whereIn('id_dokter', $dokters->pluck('id'))
    //         ->where('status', 'aktif')
    //         ->with('dokter')
    //         ->get();

    //     return response()->json($jadwal);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:table_jadwal_periksa,id',
            'id_pasien' => 'required|exists:users,id',
            'keluhan' => 'required',
        ]);

        try {
            $existingRegistration = DaftarPoli::where('id_pasien', $request->id_pasien)
                ->whereNull('deleted_at')
                ->exists();

            if ($existingRegistration) {
                Alert::error('Gagal!', 'Anda sudah mendaftar. Harap menunggu giliran diperiksa.');
                return redirect()->route('pasien.riwayat');
            }

            $no_antrian = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian') + 1;

            DaftarPoli::create([
                'id_jadwal' => $request->id_jadwal,
                'id_pasien' => $request->id_pasien,
                'keluhan' => $request->keluhan,
                'no_antrian' => $no_antrian,
            ]);

            Alert::success('Berhasil!', 'Pendaftaran berhasil! Nomor antrean Anda: ' . $no_antrian);
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage());
        }

        return redirect()->route('pasien.riwayat');
    }
}
