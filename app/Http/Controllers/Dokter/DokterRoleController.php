<?php

namespace App\Http\Controllers\Dokter;

use App\Models\DokterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Models\PoliModel;

class DokterRoleController extends Controller
{
    public function index()
    {
        $user = Auth::guard('dokter')->user();
        $data = DokterModel::where('id', $user->id)->get();
        $datapoli = PoliModel::all();
        return view('dokter.index', compact('data','datapoli'));
    }

    public function loginPage()
    {
        return view('dokter.auth.login');
    }

    public function authenticate(Request $request)
    {
        $dokter = DokterModel::where('name', $request->name)
        ->where('no_hp', $request->no_hp)
        ->first();

        if ($dokter) {
            Auth::guard('dokter')->login($dokter);
            Alert::success('Berhasil', 'Login berhasil!');
            return redirect()->route('dokter.dashboard');
        }
        Alert::error('Gagal', 'Nama atau No Hp salah.');
        return back();
        
    }

    public function logout(Request $request)
    {
        Auth::guard('dokter')->logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Berhasil', 'Log out berhasil!');

        return redirect()->route('dokter.login');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|exists:table_poli,id', 
        ]);

        $dokter = DokterModel::findOrFail($id);

        $dokter->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'id_poli' => $request->id_poli,  
        ]);
        Alert::success('Berhasil', 'Data dokter berhasil diperbarui!');

        return redirect()->route('dokter.dashboard');
    }

}
