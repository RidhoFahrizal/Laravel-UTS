<?php

namespace App\Http\Controllers\Api;

use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Resources\DepartemenResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::all();
        return new DepartemenResource(true, 'List of Departemens', $departemens);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $departemen = Departemen::create($validated);

        return new DepartemenResource(true, 'Departemen Created Successfully', $departemen);
    }

    public function show(Departemen $departemen)
    {
        return new DepartemenResource(true, 'Departemen Detail', $departemen);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);
        $departemen = departemen::findOrFail($id);

        $res = $departemen->update($validated);

        return new DepartemenResource(true, 'Departemen Updated Successfully', $departemen);
    }

    public function destroy($id)
    {
        $departemen = Departemen::find($id);
        if(!$departemen){
            return new DepartemenResource(false,'Departemen not found', null);
        }
        $departemen->delete();
        return new DepartemenResource(true, 'Departemen Deleted Successfully', null);
    }
}
