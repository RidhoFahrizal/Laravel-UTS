<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\DB;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::apiResource('karyawan', KaryawanController::class);

Route::get('/cek-koneksi-db', function () {
    try {
        DB::connection()->getPdo();
        return "Database terhubung!";
    } catch (\Exception $e) {
        return "Tidak dapat terhubung ke database: " . $e->getMessage();
    }
});

