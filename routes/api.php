<?php

use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\GajiController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\KaryawanController;

Route::apiResource('karyawan', KaryawanController::class);
Route::apiResource('departemen', DepartemenController::class);
Route::apiResource('jabatan', JabatanController::class);
Route::apiResource('gaji', GajiController::class);
Route::apiResource('absensi', AbsensiController::class);


