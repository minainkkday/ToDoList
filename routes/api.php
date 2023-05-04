<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('posts/', function (){
//     return response() -> json([
//         'posts' => [
//             [
//                 'title' => 'Post One'
//             ]
//         ]
//     ]);
// });

Route::get('/', [TodoController::class, 'index']);

// Route::get('create', [TodoController::class, 'create']);

Route::post('store-data', [TodoController::class, 'store']);

Route::get('details/{id}', [TodoController::class, 'details']);
// Route::get('edit/{id}', [TodoController::class, 'edit']);
Route::put('update/{id}', [TodoController::class, 'update']);

Route::delete('delete/{id}', [TodoController::class, 'delete']);

Route::delete('deleteAll', [TodoController::class, 'deleteAll']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
