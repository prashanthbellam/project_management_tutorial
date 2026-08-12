<?php

namespace App\Http\Controllers;

use App\Models\ProjectMaster;
use Illuminate\Http\Request;

class ProjectMasterController extends Controller
{
    public function index()
    {
        return response()->json(ProjectMaster::where('is_deleted', false)->orderByDesc('id')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $projectMaster = ProjectMaster::create($validated);

        return response()->json($projectMaster, 201);
    }

    public function show(ProjectMaster $projectMaster)
    {
        return response()->json($projectMaster, 200);
    }

    public function update(Request $request, ProjectMaster $projectMaster)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'details' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $projectMaster->update($validated);

        return response()->json($projectMaster->refresh(), 200);
    }

    public function destroy(ProjectMaster $projectMaster)
    {
        $projectMaster->is_deleted = true;
        $projectMaster->deleted_at = now();
        $projectMaster->save();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
