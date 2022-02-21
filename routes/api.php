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
/*Route::get('login', [AuthController::class, 'login']);
Route::post('/tokens/create', function (Request $request) {
    $user = User::create([
        'name' => 'walid',
        'email' => 'walid12@gmail.com',
        'password' => '12345678',
    ]);
    $token = $user->createToken('myapptoken')->plainTextToken;

    return ['token' => $token->plainTextToken];
});
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
]);
