<?php

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
Route::get('/', function () {
    return view('login');
});

Route::post('/login',[App\Http\Controllers\LoginController::class,'index'])->name('signin');
Route::get('/register',function(){ return view('signup'); })->name('signup');
Route::post('/signup',[App\Http\Controllers\RegisterController::class,'signup'])->name('register');
Route::group(['middleware' => 'auth'],function(){

    // Route::resource('product',App\Http\Controllers\ProductController::class);
    // Route::get('/product/{any}/filter',[App\Http\Controllers\ProductController::class,'filter']);
    // Route::get('/product/load/step1',[App\Http\Controllers\ProductController::class,'loadStep1']);
    // Route::post('/product/create/step1',[App\Http\Controllers\ProductController::class,'step1']);
    // Route::post('/product/create/step2',[App\Http\Controllers\ProductController::class,'step2']);
    // Route::post('/product/create/step3',[App\Http\Controllers\ProductController::class,'step3']);
    // Route::post('/product/update',[App\Http\Controllers\ProductController::class,'updateAttachment']);
    // Route::post('/product/search',[App\Http\Controllers\ProductController::class,'search']);
    // Route::get('/category',[App\Http\Controllers\CategoryController::class,'index']);
    Route::get('/logout',[App\Http\Controllers\LoginController::class,'logout'])->name('signout');    
    Route::get('/secret',[App\Http\Controllers\LoginController::class,'secret'])->name('secret');
});