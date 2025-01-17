<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\ModelJadwalPeriksa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Enums\HariEnum;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksa extends Controller
{
    public function index()
    {
        $urutanHari = [
            'Senin'    => 1,
            'Selasa'   => 2,
            'Rabu'     => 3,
            'Kamis'    => 4,
            'Jumat'    => 5,
            'Sabtu'    => 6,
            'Minggu'   => 7,
        ];

        $dokter = Auth::guard('dokter')->user();
        $data = ModelJadwalPeriksa::where('id_dokter', $dokter->id)
                         ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                         ->get();
        return view('dokter.jadwal', compact('data'));
    }

    public function store(Request $request)
    {
        $dokter = Auth::guard('dokter')->user();

        $request->validate([
            'hari' => 'required|string|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,nonaktif', 
        ]);

        try {

            $cekhari = ModelJadwalPeriksa::where('id_dokter', $dokter->id)
            ->where('hari', $request->hari)
            ->first();

            if ($cekhari) {
                Alert::error('Gagal!', 'Jadwal pada hari ' . $request->hari . ' sudah ada.');
                return redirect()->back();
            }

            if ($request->status == 'aktif') {
                ModelJadwalPeriksa::where('id_dokter', $dokter->id)
                    ->where('status', 'aktif')
                    ->update(['status' => 'nonaktif']);
            }

            ModelJadwalPeriksa::create([
                'id_dokter' => $dokter->id,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
            ]);

            Alert::success('Berhasil!', 'Jadwal pemeriksaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage());
        }

        return redirect()->route('dokter.jadwal');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required|string|max:10',
            'jam_mulai' => 'required|date_format:H:i:s',
            'jam_selesai' => 'required|date_format:H:i:s|after:jam_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            $jadwal = ModelJadwalPeriksa::findOrFail($id);

            if ($request->status == 'aktif' && $jadwal->status != 'aktif') {
                ModelJadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                    ->where('status', 'aktif')
                    ->update(['status' => 'nonaktif']);
            }

            $jadwal->update([
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
            ]);

            Alert::success('Berhasil!', 'Jadwal periksa berhasil diperbarui.');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat memperbarui data. ' . $e->getMessage());
        }

        return redirect()->route('dokter.jadwal');
    }

    public function destroy($id)
    {
        try {
            $jadwal = ModelJadwalPeriksa::findOrFail($id);


            if ($jadwal->status == 'aktif') {
                $jadwal->delete();
                $activeJadwal = ModelJadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                    ->where('status', 'aktif')
                    ->first();

                if (!$activeJadwal) {
                    ModelJadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                        ->update(['status' => 'nonaktif']);
                }
            } else {
                $jadwal->delete();
            }

            Alert::success('Berhasil!', 'Jadwal periksa berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus data. ' . $e->getMessage());
        }

        return redirect()->route('dokter.jadwal');
    }

    
}
