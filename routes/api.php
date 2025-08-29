<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TâcheController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');





Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    /*Projects Routes*/ 
    Route::get('/projects', [ProjectController::class, 'showAll']);
    Route::get('/project/{id}', [ProjectController::class, 'show']);
    Route::post('/project', [ProjectController::class, 'create']);
    Route::put('/project/{id}', [ProjectController::class, 'update']);
    Route::delete('/project/{id}', [ProjectController::class, 'delete']);
    /*Taches Routes*/

    Route::post('/projects/{id}/tasks', [TâcheController::class, 'create']);
    Route::put('/tasks/{id}', [TâcheController::class, 'update']);
    Route::delete('/tasks/{id}', [TâcheController::class, 'delete']);
    Route::patch('/tasks/{id}/status', [TâcheController::class, 'updateStatus']);

});



