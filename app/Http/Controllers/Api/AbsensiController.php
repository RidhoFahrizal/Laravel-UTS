<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Resources\AbsensiResource;
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

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status_absensi' => 'sometimes|in:hadir,izin,sakit,alpha',
            'waktu_keluar' => 'required|date_format:H:i:s',
        ]);

        $absensi->update($validated);
        return new AbsensiResource(true, 'Absensi Updated Successfully', $absensi);
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return new AbsensiResource(true, 'Absensi Deleted Successfully', null);
    }
}
