<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Authentication Routes
Route::post('login',[UserAuthController::class,'login']);
Route::post('signup',[UserAuthController::class,'signup']);

//Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('add-task',[TaskController::class,'create']);
    Route::put('complete/{task}',[TaskController::class,'complete'])->can('access','task');
    Route::get('tasks',[TaskController::class,'Tasks']);
    Route::put('task/{task}',[TaskController::class,'UpdateTask'])->can('update','task');
    Route::delete('delete/{task}',[TaskController::class,'DeleteTask'])->can('delete','task');;
    Route::post('task/{task}/note',[TaskController::class,'addNote'])->can('access','task');
});
