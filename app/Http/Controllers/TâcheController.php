<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TacheResource;


class TâcheController extends Controller
{
    
    public function showAll(Request $req, string $id) {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }
        $tasks = $projects->taches;
        return resposne()->json([
            'success' => true,
            'data' => TacheResource::collection($tasks),
        ]);
    }



    public function create(TaskRequest $req, string $id) {
        $data = $req->validated();
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        $task = Task::create(array_merge($data, [
            'project_id' => $id,
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => new TacheResource($task),
        ], 201);
    }



    public function update(TaskRequest $req, string $id) {
        $data = $req->validated();
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        foreach($data as $key => $value) {
            $task->$key = $value;
        }

        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully',
            'data' => new TacheResource($task),
        ]);
    }



    public function delete(Request $req, string $id) {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }
     
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record was deleted successfully',
        ]);
    }



    public function updateStatus(Request $req, string $id) {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        $validated = $req->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->status = $validated['status'];
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Record status has been updated successfully',
        ]);
    }


    
}
