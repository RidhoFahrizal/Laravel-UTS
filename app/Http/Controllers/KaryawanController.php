<?php

namespace App\Http\Controllers;


//CATATAN
// CONTORLLER KARYAWAN BERDASARKAN PASSWORD SUDAH SELESAI



use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Resources\KaryawanResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $karyawans = Karyawan::all();
        return new KaryawanResource(true, 'List of Departemens', $karyawans);
    }

    // Menyimpan karyawan baru
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:karyawans,email',
            'nomor_telepon' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'status' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $karyawan =Karyawan::create($validated);

        return new KaryawanResource(true, 'List of Departemens', $karyawan);
    }
    // Menampilkan detail karyawan
    public function show(Karyawan $karyawan)
    {
        return new KaryawanResource(true, 'Karyawan Detail', $karyawan);
    }

    // Mengupdate karyawan
/**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:karyawans,email,' . $karyawan->id,
            'nomor_telepon' => 'sometimes|required|string',
            'tanggal_lahir' => 'sometimes|required|date',
            'alamat' => 'sometimes|required|string',
            'tanggal_masuk' => 'sometimes|required|date',
            'departemen_id' => 'sometimes|required|exists:departemens,id',
            'jabatan_id' => 'sometimes|required|exists:jabatans,id',
            'status' => 'sometimes|required|string',
            'password' => 'sometimes|required|string|min:8',
        ]);

        $karyawan->update($validated);

        return response()->json(['message' => 'Karyawan berhasil diperbarui']);
    }

    // Menghapus karyawan
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return new KaryawanResource(true, 'Karyawan Deleted Successfully', null);
    }






































   // KARYAWAN ABSEN DISINI

    public function absen(Request $request)
{
    $validatedData = $request->validate([
        'karyawan_id' => 'required|exists:karyawans,id',
        'tanggal' => 'required|date',
    ]);

    $absensi = Absensi::where('karyawan_id', $validatedData['karyawan_id'])
                      ->where('tanggal', $validatedData['tanggal'])
                      ->first();

    if (!$absensi) {
        // Absen masuk
        $absensi = Absensi::create([
            'karyawan_id' => $validatedData['karyawan_id'],
            'tanggal' => $validatedData['tanggal'],
            'waktu_masuk' => now(),
            'waktu_keluar' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil absen masuk.',
            'data' => $absensi,
        ]);
    } else {
        // Absen keluar
        if ($absensi->waktu_keluar === $absensi->waktu_masuk) {
            $absensi->update([
                'waktu_keluar' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil absen keluar.',
                'data' => $absensi,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda sudah absen keluar.',
        ]);
    }
}

}
