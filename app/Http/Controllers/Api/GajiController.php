<?php

namespace App\Http\Controllers\Api;

use App\Models\Gaji;
use App\Http\Resources\GajiResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::all();

        return new GajiResource(true, 'List of Gajis', $gajis);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        $totalGaji = $validatedData['gaji_pokok']
                    + ($validatedData['tunjangan'] ?? 0)
                    - ($validatedData['potongan'] ?? 0);

        $gaji = Gaji::create([
            'karyawan_id' => $validatedData['karyawan_id'],
            'bulan' => $validatedData['bulan'],
            'gaji_pokok' => $validatedData['gaji_pokok'],
            'tunjangan' => $validatedData['tunjangan'],
            'potongan' => $validatedData['potongan'],
            'total_gaji' => $totalGaji,
        ]);

        return response()->json([
            'message' => 'Data gaji berhasil ditambahkan',
            'data' => $gaji
        ], 201);
    }

    public function show(Gaji $gaji)
    {
        return new GajiResource(true, 'Gaji Detail', $gaji);
    }

    public function update(Request $request, Gaji $gaji)
    {
        $validatedData = $request->validate([
            'karyawan_id' => 'sometimes|exists:karyawans,id',
            'bulan' => 'sometimes|string|max:10',
            'gaji_pokok' => 'sometimes|numeric|min:0',
            'tunjangan' => 'sometimes|nullable|numeric|min:0',
            'potongan' => 'sometimes|nullable|numeric|min:0',
        ]);

        // Update hanya kolom yang ada dalam request
        $gaji->update($validatedData);

        return response()->json([
            'message' => 'Gaji Updated Successfully',
            'data' => $gaji
        ], 200);
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();

        return new GajiResource(true, 'Gaji Deleted Successfully', null);
    }
}

