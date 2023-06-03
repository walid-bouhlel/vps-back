<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VpsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/ 
    // cmd to show all valid routes : php artisan route:list

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//public
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
//protected
Route::group(['middleware'=>['auth:sanctum']], function() {
    Route::get('/check',[AuthController::class,'check']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::resource('/vps',VpsController::class);
});
