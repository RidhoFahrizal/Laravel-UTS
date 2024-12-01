<?php

namespace App\Http\Controllers;

//CONTROLLER MANAGER SUDAH BERSAMA PASSWORD (DONE)




use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResource;
class ManagerController extends Controller
{
    // Melihat semua absensi di departemen manajer

    public function index()
    {
        $managers = Manager::all();
        return new ManagerResource(true, 'List of Managers', $managers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:managers,email',
            'nomor_telepon' => 'required|string',
            'departemen_id' => 'required|exists:departemens,id',
            'password' => 'required|string|min:8',
        ]);

        Manager::create($validated);

        return response()->json(['message' => 'Manager berhasil ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:managers,email,' . $manager->id,
            'nomor_telepon' => 'sometimes|required|string',
            'departemen_id' => 'sometimes|required|exists:departemens,id',
            'password' => 'sometimes|required|string|min:8',
        ]);

        $manager->update($validated);

        return response()->json(['message' => 'Manager berhasil diperbarui']);

}

    public function destroy($id)
    {
    $manager = Manager::find($id);

    if (!$manager) {
        return response()->json([
            'success' => false,
            'message' => 'Manager not found',
        ], 404);
    }

    $manager->delete();

    return response()->json([
        'success' => true,
        'message' => 'Manager successfully deleted',
    ]);
}


    public function getAbsensi(Request $request)
    {
        $user = auth()->user();

        // Validasi peran pengguna sebagai manajer
        if ($user->role !== 'manager') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Ambil semua absensi dari departemen manajer
        $absensis = Absensi::whereHas('karyawan', function ($query) use ($user) {
            $query->where('departemen_id', $user->departemen_id);
        })->get();

        return response()->json([
            'success' => true,
            'message' => 'List of absensi in your department',
            'data' => $absensis,
        ]);
    }

    // Tambahkan absensi untuk karyawan tertentu
    public function addAbsensi(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $user = auth()->user();

        // Validasi manajer hanya bisa mengelola karyawan di departemennya
        $karyawan = Karyawan::find($validated['karyawan_id']);
        if ($karyawan->departemen_id != $user->departemen_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Tambahkan absensi
        $absensi = Absensi::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Absensi successfully added',
            'data' => $absensi,
        ]);
    }

    // Mengubah absensi karyawan
    public function updateAbsensi(Request $request, $id)
    {
        $validated = $request->validate([
            'status_absensi' => 'nullable|in:hadir,izin,sakit,alpha',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'waktu_masuk' => 'nullable|date_format:H:i',
        ]);

        $user = auth()->user();

        // Cari absensi
        $absensi = Absensi::find($id);
        if (!$absensi) {
            return response()->json(['success' => false, 'message' => 'Absensi not found'], 404);
        }

        // Validasi manajer hanya bisa mengelola absensi di departemennya
        if ($absensi->karyawan->departemen_id != $user->departemen_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Perbarui data absensi
        if (isset($validated['waktu_keluar'])) {
            $absensi->waktu_keluar = $validated['waktu_keluar'];
        }
        if (isset($validated['status_absensi'])) {
            $absensi->status_absensi = $validated['status_absensi'];
        }
        if (isset($validated['waktu_masuk'])) {
            $absensi->waktu_masuk = $validated['waktu_masuk'];
        }

        $absensi->save();

        return response()->json([
            'success' => true,
            'message' => 'Absensi successfully updated',
            'data' => $absensi,
        ]);
    }

    public function buatJadwalAbsensi(Request $request)
{
    $validatedData = $request->validate([
        'departemen_id' => 'required|exists:departemens,id',
        'tanggal' => 'required|date',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai',
    ]);

    $jadwal = JadwalAbsensi::create($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'Jadwal absensi berhasil dibuat.',
        'data' => $jadwal,
    ]);
}

}
