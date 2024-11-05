<?php

namespace App\Http\Controllers\Api;

use App\Models\jabatan;
use Illuminate\Http\Request;
use App\Http\Resources\JabatanResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();

        return new JabatanResource(true, 'List of Jabatans', $jabatans);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100',
        ]);

        $jabatan = Jabatan::create($validated);

        return new JabatanResource(true, 'Jabatan Created Successfully', $jabatan);
    }

    public function show(Jabatan $jabatan)
    {
        return new JabatanResource(true, 'Jabatan Detail', $jabatan);
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'sometimes|string|max:100',
        ]);

        $jabatan->update($validated);

        return new JabatanResource(true, 'Jabatan Updated Successfully', $jabatan);
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return new JabatanResource(true, 'Jabatan Deleted Successfully', null);
    }
}
