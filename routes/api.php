<?php

use App\Models\User;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\QuestionController;

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
//User
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('allUsers', [AuthController::class, 'showUser']);
Route::post('store-user', [AuthController::class, 'storeUser']);
Route::get('edituser/{id}', [AuthController::class, 'edit']);
Route::put('updateUser/{id}', [AuthController::class, 'update']);
Route::delete('deleteUser/{id}', [AuthController::class, 'destroy']);
Route::put('changeStatut/{id}', [AuthController::class, 'changeStatut']);
Route::post('forgot', [\App\Http\Controllers\PasswordController::class, 'forgot']);
Route::post('reset', [\App\Http\Controllers\PasswordController::class, 'reset']);
Route::get('get-profile', [AuthController::class, 'getCurentUser']);

//Stagiaire
Route::post('/stagiaire/register', [\App\Http\Controllers\API\StagiaireController::class, 'register']);
Route::post('/stagiaire/login', [\App\Http\Controllers\API\StagiaireController::class, 'login']);
//Question
Route::post('/addQuestion', [\App\Http\Controllers\QuestionController::class, 'addquestion']);
Route::get('/allQuestions', [\App\Http\Controllers\QuestionController::class, 'showQuestion']);
Route::get('/editQuestion/{id}', [\App\Http\Controllers\QuestionController::class, 'editQuestion']);
Route::put('/updateQuestion/{id}', [\App\Http\Controllers\QuestionController::class, 'updateQuestion']);
Route::delete('/deleteQuestion/{id}', [\App\Http\Controllers\QuestionController::class, 'destroy']);

//Response
Route::post('/addResponse', [\App\Http\Controllers\ReponseController::class, 'addReponse']);




Route::middleware('auth:sanctum', 'isAPIAdmin')->group(function () {


    return response()->json(['message' => 'You are in', 'status' => 200], 200);
});
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});

/*Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
]);*/
