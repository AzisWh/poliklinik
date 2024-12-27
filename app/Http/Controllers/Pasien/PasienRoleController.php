<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DokterModel;
use App\Models\PoliModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PasienRoleController extends Controller
{
    public function authPage()
    {
        return view('pasien.auth.index');
    }

    public function index()
    {
        $policount = PoliModel::count();
        $count = DokterModel::count();
        return view('pasien.index', compact('count','policount'));
    }

    public function profile()
    {
        $user = Auth::guard('pasien')->user();
        $data = User::where('id', $user->id)->get();
        return view('pasien.profile', compact('data'));
    }

    private function generateNoRM()
    {
        $yearMonth = Carbon::now()->format('Ym');

        // Ambil pasien terakhir yang no_rm-nya sesuai format bulan-tahun
        $lastPatient = User::where('no_rm', 'like', $yearMonth . '%')
            ->orderBy('no_rm', 'desc')
            ->first();

        $lastNo = $lastPatient ? (int)substr($lastPatient->no_rm, -3) : 0;
        $nextNo = str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);

        return $yearMonth . '-' . $nextNo;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|unique:users,no_ktp',
            'no_hp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $no_rm = $this->generateNoRM();

        $user = User::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $no_rm,
        ]);

        Auth::guard('pasien')->login($user);
        Alert::success('Berhasil', 'Registrasi berhasil!');

        return redirect()->route('pasien.dashboard');
    }

    public function login(Request $request)
    {
        $pasien = User::where('name', $request->name)
        ->where('no_ktp', $request->no_ktp)
        ->first();

        if ($pasien) {
            Auth::guard('pasien')->login($pasien);
            Alert::success('Berhasil', 'Login berhasil!');
            return redirect()->route('pasien.dashboard');
        }
        Alert::error('Gagal', 'Nama atau No KTP salah.');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pasien.login')->with('success', 'You have successfully logged out.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'no_ktp' => 'required|string', 
        ]);

        $pasien = User::findOrFail($id);

        $pasien->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,  
        ]);
        Alert::success('Berhasil', 'Data pasien berhasil diperbarui!');

        return redirect()->route('pasien.profile');
    }
}
