<?php

namespace App\Http\Controllers;

use App\Models\TasksMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksMasterController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = TasksMaster::query()
            ->with(['parent', 'children'])
            ->whereNull('parent_id')
            ->where('is_deleted', false)
            ->orderBy('task_order')
            ->get();

        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'task' => [
                'required',
                'string',
                'max:255',
            ],
            'task_details' => [
                'nullable',
                'string',
            ],
            'task_order' => [
                'sometimes',
                'integer',
            ],
        ]);

        $task = new TasksMaster($validated);
        $task->save();

        return response()->json($task, 201);
    }

    public function storeSubtask(Request $request, TasksMaster $task): JsonResponse
    {
        if ($task->is_deleted) {
            abort(404);
        }

        $validated = $request->validate([
            'task' => [
                'required',
                'string',
                'max:255',
            ],
            'task_details' => [
                'nullable',
                'string',
            ],
            'task_order' => [
                'sometimes',
                'integer',
            ],
        ]);

        $subtask = new TasksMaster($validated);
        $subtask->parent_id = $task->id;
        $subtask->save();

        return response()->json($subtask, 201);
    }

    public function subtasks(TasksMaster $task): JsonResponse
    {
        if ($task->is_deleted) {
            abort(404);
        }

        $subtasks = TasksMaster::query()
            ->where('parent_id', $task->id)
            ->where('is_deleted', false)
            ->orderBy('task_order')
            ->get();

        return response()->json($subtasks);
    }

    public function destroySubtask(TasksMaster $task,TasksMaster $subtask): JsonResponse 
    {
        if (
            $task->is_deleted ||
            $subtask->is_deleted ||
            (int) $subtask->parent_id !== (int) $task->id
        ) {
            abort(404);
        }

        $subtask->is_deleted = true;
        $subtask->deleted_at = now();
        $subtask->save();

        return response()->json([
            'message' => 'Subtask deleted successfully.',
        ]);
    }

    public function show(TasksMaster $tasksMaster): JsonResponse
    {
        if ($tasksMaster->is_deleted) {
            abort(404);
        }

        $tasksMaster->load([
            'parent',
            'children',
        ]);

        return response()->json($tasksMaster);
    }

    public function update(Request $request, TasksMaster $tasksMaster): JsonResponse
    {
        if ($tasksMaster->is_deleted) {
            abort(404);
        }

        $validated = $request->validate([
            'task' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'task_details' => [
                'nullable',
                'string',
            ],
            'task_order' => [
                'sometimes',
                'integer',
            ],
        ]);

        $tasksMaster->fill($validated);
        $tasksMaster->save();

        return response()->json($tasksMaster->fresh());
    }

    public function destroy(TasksMaster $tasksMaster): JsonResponse
    {
        if ($tasksMaster->is_deleted) {
            abort(404);
        }

        $tasksMaster->is_deleted = true;
        $tasksMaster->deleted_at = now();
        $tasksMaster->save();

        return response()->json([
            'message' => 'Task deleted successfully.',
        ]);
    }
}
