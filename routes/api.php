<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('product',App\Http\Controllers\ProductController::class);
    Route::get('/product/{any}/filter',[App\Http\Controllers\ProductController::class,'filter']);
    Route::get('/product/load/step1',[App\Http\Controllers\ProductController::class,'loadStep1']);
    Route::post('/product/create/step1',[App\Http\Controllers\ProductController::class,'step1']);
    Route::post('/product/create/step2',[App\Http\Controllers\ProductController::class,'step2']);
    Route::post('/product/create/step3',[App\Http\Controllers\ProductController::class,'step3']);
    Route::post('/product/update',[App\Http\Controllers\ProductController::class,'updateAttachment']);
    Route::post('/product/search',[App\Http\Controllers\ProductController::class,'search']);
    Route::get('/category',[App\Http\Controllers\CategoryController::class,'index']);
});

