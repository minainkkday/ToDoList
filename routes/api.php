<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::prefix('/todos')->group(function (){
    //GET
    Route::get('/', [TodoController::class, 'index']);
    Route::get('{id}', [TodoController::class, 'details'])->whereNumber('id');//Routing - constraints, 404 error code by default 

    //POST
    Route::post('/', [TodoController::class, 'store']);

    //PUT
    Route::put('{id}', [TodoController::class, 'update'])->whereNumber('id');

    //DELETE
    Route::delete('/', [TodoController::class, 'deleteAll']);
    Route::delete('{id}', [TodoController::class, 'delete'])->whereNumber('id');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
