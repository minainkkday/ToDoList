<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     // return view('welcome');
//     return redirect("about");
// });

// Route::get("path", "controller file");
// Route::get("users/{user}", [Users::class, 'index']);

// Route::get('/hello', function (){
//     return response('<h1>HELLO World</h1>');
// });

// Route::view('/', "index");//url, page name(from views), short version of calling view

// Route::get('/', [TodoController::class, 'index']);

// Route::get('create', [TodoController::class, 'create']);

// Route::post('store-data', [TodoController::class, 'store']);

// Route::get('details/{todo}', [TodoController::class, 'details']);
// Route::get('edit/{todo}', [TodoController::class, 'edit']);
// Route::post('update/{todo}', [TodoController::class, 'update']);

// Route::get('delete/{todo}', [TodoController::class, 'delete']);

// Route::post('store-data', [TodoController::class, 'store']);

// Route::get('posts/{id}', function ($id){
//     return response("Post " . $id);
// }) -> where('id', '[0-9]+');//regex expression to restrict if it is a correct type

// //dd($id) -> It will show the id on the webpage(Die Dump)
// //ddd($id) -> Dump, Die, Debug It will also show the debugging with more information. Shows the entire request.

// Route::get('/search', function(Request $request){
//     dd($request);
//     // return $request->name . " ". $request->city;
// });
