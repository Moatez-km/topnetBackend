<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\API\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('allUsers', [AuthController::class, 'showUser']);
Route::post('store-user', [AuthController::class, 'storeUser']);
Route::get('edituser/{id}', [AuthController::class, 'edit']);
Route::put('updateUser/{id}', [AuthController::class, 'update']);
Route::delete('deleteUser/{id}', [AuthController::class, 'destroy']);
Route::put('changeStatut/{id}', [AuthController::class, 'changeStatut']);


Route::middleware('auth:sanctum', 'isAPIAdmin')->group(function () {

    return response()->json(['message' => 'You are in', 'status' => 200], 200);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
]);
