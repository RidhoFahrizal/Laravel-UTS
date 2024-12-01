<?php

use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\GajiController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ManagerController;


Route::apiResource('managers', ManagerController::class);
Route::apiResource('karyawan', KaryawanController::class);
Route::apiResource('departemen', DepartemenController::class);
Route::apiResource('jabatan', JabatanController::class);
Route::apiResource('gaji', GajiController::class);
Route::apiResource('absensi', AbsensiController::class);

// Routes untuk Manager dan karyawan absen 
Route::post('/manager/jadwal-absensi', [ManagerController::class, 'buatJadwalAbsensi']);
Route::post('/karyawan/absen', [KaryawanController::class, 'absen']);


// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
