<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Resources\AbsensiResource;
use App\Http\Resources\KaryawanResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::all();
        return new AbsensiResource(true, 'List of Absensis', $absensis);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);


        $absensi = Absensi::create($validated);
        return new AbsensiResource(true, 'Absensi Created Successfully', $absensi);
    }

    public function show(Absensi $absensi)
    {
        return new AbsensiResource(true, 'Absensi Detail', $absensi);
    }

    public function update(Request $request, $karyawan_id)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date', // Tanggal diperlukan untuk mencari data absensi
            'status_absensi' => 'nullable|in:hadir,izin,sakit,alpha', // Status absensi opsional
            'waktu_keluar' => 'nullable|date_format:H:i', // Waktu keluar opsional dan harus dalam format jam:menit
            'waktu_masuk' => 'nullable|date_format:H:i', // Waktu masuk opsional untuk klarifikasi
        ]);

        // Cari data absensi berdasarkan karyawan_id dan tanggal
        $absensi = Absensi::where('karyawan_id', $karyawan_id)
                          ->where('tanggal', $validated['tanggal'])
                          ->first();

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi not found'
            ], 404);
        }

        // Logika untuk absen masuk dan absen keluar
        if (isset($validated['waktu_keluar'])) {
            // Cek jika karyawan belum absen masuk, tidak bisa absen keluar
            if (!$absensi->waktu_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan belum absen masuk, tidak bisa absen keluar'
                ], 400);
            }
            // Update waktu_keluar jika absensi masuk sudah ada
            $absensi->waktu_keluar = $validated['waktu_keluar'];
        }

        // Logika untuk klarifikasi kehadiran atau mengganti status_absensi
        if (isset($validated['status_absensi'])) {
            $absensi->status_absensi = $validated['status_absensi'];
        }

        // Jika waktu masuk diklarifikasi (hanya jika diperlukan oleh admin)
        if (isset($validated['waktu_masuk'])) {
            $absensi->waktu_masuk = $validated['waktu_masuk'];
        }

        // Simpan perubahan pada absensi
        $absensi->save();

        return new AbsensiResource(true, 'Absensi Updated Successfully', $absensi);
    }



    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return new AbsensiResource(true, 'Absensi Deleted Successfully', null);
    }
}
