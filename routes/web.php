<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Dokter\DokterRoleController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Dokter\JadwalPeriksa;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Dokter\RiwayatPeriksaController;
use App\Http\Controllers\Pasien\DaftarPoliController;
use App\Http\Controllers\Pasien\PasienRoleController;
use App\Http\Controllers\Pasien\PendaftaranPoliController;
use App\Http\Controllers\Pasien\RiwayatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//admin
Route::get('/admin-login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin-login', [AdminController::class, 'authenticate'])->name('admin.login');

//admin
Route::middleware(['check_user_login:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin-logout', [AdminController::class, 'logout'])->name('admin.logout');

    //poli
    Route::get('/poli', [PoliController::class, 'index'])->name('admin.poli');
    Route::post('/poli', [PoliController::class, 'store'])->name('admin.poli.store');
    Route::patch('/poli/{poli}', [PoliController::class, 'update'])->name('admin.poli.update');
    Route::delete('/poli/{poli}', [PoliController::class, 'destroy'])->name('admin.poli.destroy');

    //dokter
    Route::get('/dokter', [DokterController::class, 'index'])->name('admin.dokter');
    Route::post('/dokter', [DokterController::class, 'store'])->name('admin.dokter.store');
    Route::patch('/dokter/{dokter}', [DokterController::class, 'update'])->name('admin.dokter.update');
    Route::delete('/dokter/{dokter}', [DokterController::class, 'destroy'])->name('admin.dokter.destroy');

    //obat
    Route::get('/obat', [ObatController::class, 'index'])->name('admin.obat');
    Route::post('/obat', [ObatController::class, 'store'])->name('admin.obat.store');
    Route::patch('/obat/{obat}', [ObatController::class, 'update'])->name('admin.obat.update');
    Route::delete('/obat/{obat}', [ObatController::class, 'destroy'])->name('admin.obat.destroy');

    //pasien
    Route::get('/pasien', [PasienController::class, 'index'])->name('admin.pasien');
    Route::post('/pasien', [PasienController::class, 'store'])->name('admin.pasien.store');
    Route::patch('/pasien/{pasien}', [PasienController::class, 'update'])->name('admin.pasien.update');
    Route::delete('/pasien/{pasien}', [PasienController::class, 'destroy'])->name('admin.pasien.destroy');
});

//dokter
Route::get('/dokter-login', [DokterRoleController::class, 'loginPage'])->name('dokter.login');
Route::post('/dokter-login', [DokterRoleController::class, 'authenticate'])->name('login');

//dokter
Route::middleware(['check_user_login:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', [DokterRoleController::class, 'index'])->name('dokter.dashboard');
    Route::post('/dokter-logout', [DokterRoleController::class, 'logout'])->name('dokter.logout');

    //profile
    Route::patch('/profile/{profile}', [DokterRoleController::class, 'update'])->name('dokter.profile.update');

    //jadwal
    Route::get('/jadwal', [JadwalPeriksa::class, 'index'])->name('dokter.jadwal');
    Route::post('/jadwal', [JadwalPeriksa::class, 'store'])->name('dokter.jadwal.store');
    Route::patch('/jadwal/{jadwal}', [JadwalPeriksa::class, 'update'])->name('dokter.jadwal.update');
    Route::delete('/jadwal/{jadwal}', [JadwalPeriksa::class, 'destroy'])->name('dokter.jadwal.destroy');

    // periksa
    Route::get('/periksa', [PeriksaController::class, 'index'])->name('dokter.periksa');
    Route::post('/periksa', [PeriksaController::class, 'store'])->name('dokter.periksa.store');
    
    // riwayat
    Route::get('/riwayat', [RiwayatPeriksaController::class, 'index'])->name('dokter.riwayat');
});

//pasien
Route::get('/', [PasienRoleController::class, 'authPage'])->name('pasien.login');
Route::post('/', [PasienRoleController::class, 'login'])->name('pasien.login');
Route::post('/register', [PasienRoleController::class, 'register'])->name('pasien.register');

Route::middleware(['check_user_login:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', [PasienRoleController::class, 'index'])->name('pasien.dashboard');
    Route::post('/pasien-logout', [PasienRoleController::class, 'logout'])->name('pasien.logout');
    // profile
    Route::get('/profile', [PasienRoleController::class, 'profile'])->name('pasien.profile');
    Route::patch('/profile/{profile}', [PasienRoleController::class, 'update'])->name('pasien.profile.update');

    // daftar poli
    Route::get('/poli', [PendaftaranPoliController::class, 'index'])->name('pasien.poli');
    Route::get('/get-poli/{id}', [PendaftaranPoliController::class, 'getJadwal']);
    Route::post('/poli/store', [PendaftaranPoliController::class, 'store'])->name('pasien.poli.store');
    
    // riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('pasien.riwayat');
    // Route::get('/riwayat/detail-periksa/{id}', [RiwayatController::class, 'detailPeriksa'])->name('pasien.detail-periksa');
});
