<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LicenceMaster;
use Illuminate\Http\Request;

class LicenceMasterController extends Controller
{
    public function index()
    {
        $licences = LicenceMaster::where('is_deleted', false)->get();

        return response()->json([
            'success' => true,
            'data' => $licences
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'required_for' => 'nullable|string|max:255',
            'created_by' => 'required|integer',
            'updated_by' => 'required|integer',
        ]);

        $licence = LicenceMaster::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Licence created successfully',
            'data' => $licence
        ], 201);
    }

    public function show(string $id)
    {
        $licence = LicenceMaster::where('is_deleted', false)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $licence
        ]);
    }

    public function update(Request $request, string $id)
    {
        $licence = LicenceMaster::where('is_deleted', false)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'required_for' => 'nullable|string|max:255',
            'updated_by' => 'required|integer',
        ]);

        $licence->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Licence updated successfully',
            'data' => $licence
        ]);
    }

    public function destroy(string $id)
    {
        $licence = LicenceMaster::where('is_deleted', false)
            ->findOrFail($id);

        $licence->update([
            'is_deleted' => true,
            'deleted_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Licence deleted successfully'
        ]);
    }
}