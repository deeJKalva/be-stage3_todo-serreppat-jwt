<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'me']);
    Route::get('todos', [TodoController::class, 'index']); // show all todos
    Route::post('todos', [TodoController::class, 'store']); // create a todo
    Route::get('todos/{title}', [TodoController::class, 'show']); // show a todo's detail by its title
    Route::patch('todos/{title}', [TodoController::class, 'update']); // update a todo
    Route::delete('todos/{title}', [TodoController::class, 'destroy']); // delete a todo
});