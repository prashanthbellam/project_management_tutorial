<?php

namespace App\Http\Controllers;

use App\Models\TimelineMaster;
use Illuminate\Http\Request;

class TimelineMasterController extends Controller
{
    public function index()
    {
        return response()->json(TimelineMaster::where('is_deleted', false)->orderByDesc('id')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stage' => 'required|string|max:255',
            'responsibility' => 'nullable|string',
            'is_micro' => 'sometimes|boolean',
            'is_major' => 'sometimes|boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $validated['is_micro'] = $validated['is_micro'] ?? false;
        $validated['is_major'] = $validated['is_major'] ?? false;

        $timelineMaster = TimelineMaster::create($validated);

        return response()->json($timelineMaster, 201);
    }

    public function show(TimelineMaster $timelineMaster)
    {
        return response()->json($timelineMaster, 200);
    }

    public function update(Request $request, TimelineMaster $timelineMaster)
    {
        $validated = $request->validate([
            'stage' => 'sometimes|required|string|max:255',
            'responsibility' => 'nullable|string',
            'is_micro' => 'sometimes|boolean',
            'is_major' => 'sometimes|boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $timelineMaster->update($validated);

        return response()->json($timelineMaster->refresh(), 200);
    }

    public function destroy(TimelineMaster $timelineMaster)
    {
        $timelineMaster->is_deleted = true;
        $timelineMaster->deleted_at = now();
        $timelineMaster->save();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function storeSubTimeline(Request $request, TimelineMaster $timeline)
    {
        $validated = $request->validate([
            'stage' => 'required|string|max:255',
            'responsibility' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $validated['is_micro'] = true;
        $validated['is_major'] = false;

        $subTimeline = new TimelineMaster($validated);
        $subTimeline->parent_id = $timeline->id;
        $subTimeline->save();

        return response()->json($subTimeline, 201);
    }

    public function subTimelines(TimelineMaster $timeline)
    {
        $subTimelines = TimelineMaster::where('parent_id', $timeline->id)
            ->where('is_deleted', false)
            ->orderBy('id')
            ->get();

        return response()->json($subTimelines, 200);
    }

    public function destroySubTimeline(TimelineMaster $timeline, TimelineMaster $subTimeline)
    {
        if ((int) $subTimeline->parent_id !== (int) $timeline->id) {
            return response()->json([
                'message' => 'SubTimeline does not belong to this timeline.',
            ], 404);
        }

        $subTimeline->is_deleted = true;
        $subTimeline->deleted_at = now();
        $subTimeline->save();

        return response()->json([
            'message' => 'SubTimeline deleted successfully',
        ], 200);
    }
}
