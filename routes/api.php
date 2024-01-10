<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VpsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlavorController;
use App\Http\Controllers\OpenStack\ResourcesInStackController;
use App\Http\Controllers\DistributionController;

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

//RESOURCES IN STACK
    Route::get('/flavorstack', [ResourcesInStackController::class, 'getFlavorsInStack']);
    Route::get('/imagestack', [ResourcesInStackController::class, 'getImagesInStack']);
    Route::get('/imagestackdetails', [ResourcesInStackController::class, 'test']);
//FLAVOR
    Route::post('flavor/store', [FlavorController::class, 'storeFlavor']);
    Route::get('/flavor', [FlavorController::class, 'index']);
    Route::get('/flavor/{flavor}', [FlavorController::class, 'show']);
    Route::delete('/flavor/{flavor}', [FlavorController::class, 'destroy']);

//protected
Route::group(['middleware'=>['auth:sanctum']], function() {
    Route::get('/check',[AuthController::class,'check']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::resource('/vps',VpsController::class);
});



Route::apiResource('distributions', DistributionController::class);