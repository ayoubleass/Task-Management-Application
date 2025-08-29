<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    
    public function showAll(Request $req)
    {
        $user = $req->user();
        return response()->json([
            'succes'=> true,
            'data' => ProjectResource::collection($user->projects),
        ], 200);
    }


    public function show(Request $req, string $id) 
    {
        $user = $req->user();
        $userId = $user->id;
        $project = Project::where('user_id', $userId)
                            ->where('id', $id)
                            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($project) ,
        ], 200);
    }



    public function create(ProjectRequest $req) {
        $userId = $req->user()->id;
        $data = $req->validated();


        $project = Project::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $userId,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => new ProjectResource($project),
        ], 201);
    }



    public function update(ProjectRequest $req, string $id) {
        $project = Project::find($id);
        if (!$project) {
            response()->json([
                'success' => false,
                'message' => 'Record not found',
            ]);
        }

        if ($project->user_id !== $req->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $data = $req->validated();
        
        
        foreach($data as $key => $value) {
            $project->$key = $value;
        }
        
        $project->save();
        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully',
            'data' => new ProjectResource($project),
        ]);
    }




    public function delete(Request $req, string $id) {
        $project = Project::find($id);
        if (!$project) {
            response()->json([
                'success' => false,
                'message' => 'Record not found',
            ]);
        }

        if ($project->user_id !== $req->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $project->delete();

        return response()->json([
            'status' => true,
            'message' => 'Record is deleted succefly'
        ]);
    }
    
}
