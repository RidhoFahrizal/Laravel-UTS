<?php

namespace App\Http\Controllers;

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
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'sometimes|string',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'sometimes|integer|exists:departemens,id',
            'jabatan_id' => 'required|integer|exists:jabatans,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $karyawan = Karyawan::create([
            'nama_lengkap'     => $request->nama_lengkap,
            'email'     => $request->email,
            'nomor_telepon'   => $request->nomor_telepon,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'alamat'   => $request->alamat,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'departemen_id'   => $request->departemen_id,
            'jabatan_id'      => $request->jabatan_id,
            'status'          => $request->status
        ]);

        //return response
        return new KaryawanResource(true, 'Data Karyawan Berhasil Ditambahkan!', $karyawan);
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
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'sometimes|string|max:100',
            'email' => 'sometimes|string|email|max:100|unique:karyawans,email',
            'nomor_telepon' => 'sometimes|string|max:15',
            'tanggal_lahir' => 'sometimes|date',
            'alamat' => 'sometimes|string',
            'tanggal_masuk' => 'sometimes|date',
            'departemen_id' => 'sometimes|integer|exists:departemens,id',
            'jabatan_id' => 'sometimes|integer|exists:jabatans,id',
            'status' => 'sometimes|in:aktif,nonaktif',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $karyawan = karyawan::find($id);

        // karyawan update
        $karyawan->update($request->all());

        //return response
        return new KaryawanResource(true, 'Data Karyawan Berhasil Diubah!', $karyawan);
    }
    // Menghapus karyawan
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return new KaryawanResource(true, 'Karyawan Deleted Successfully', null);
    }
}
