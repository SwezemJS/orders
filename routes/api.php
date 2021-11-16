<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
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

Route::prefix('orders')->group(function (){
    Route::get('/list',[OrderController::class,'list']);
    Route::get('/get/{id}',[OrderController::class,'get'])->where('id', '[0-9]+');
    Route::get('/delete/{id}',[OrderController::class,'delete'])->where('id', '[0-9]+');
    Route::post('/create',[OrderController::class,'create']);
    Route::post('/update',[OrderController::class,'update']);
    Route::post('/report',[OrderController::class,'report']);
});
Route::prefix('users')->group(function (){
    Route::get('/list',[UserController::class,'list']);
});
Route::prefix('products')->group(function (){
    Route::get('/list',[ProductController::class,'list']);
});
