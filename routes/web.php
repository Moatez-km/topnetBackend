<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionController;

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

Route::get('/', [PostController::class, 'index'])->name('welcome');
//Route::get('/posts/{id}', [PostController:: class,'show'])->whereNumber('id');
Route::get('/contact', [PostController::class, 'contact'])->name('contact');

Route::get('/post/{slug}', [PostController::class, 'show']);



//Route::get('/posts',function(){
//   return response() ->json([
//       'title' =>'mon super titre',
//       'description'=> 'ma super description'
//    ]);
//});

//Route::get('/articles',function(){
//    return view('articles');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
