<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OSController;
use App\Http\Controllers\VpsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlavorController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\OpenStack\ResourcesInStackController;

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
//TEST
Route::post('server/test', [ResourcesInStackController::class, 'testcreateServer']);
Route::get('server/test2', [ResourcesInStackController::class, 'testretrieveServer']);
//protected
Route::group(['middleware'=>['auth:sanctum']], function() {
    Route::get('/check',[AuthController::class,'check']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::resource('/vps',VpsController::class);
    Route::get('/vps/{id}/stop',[VpsController::class,'stop']);
    Route::get('/vps/{id}/start',[VpsController::class,'start']);
    Route::get('/vps/{id}/status',[VpsController::class,'status']);
    Route::get('/vps/{id}/reboot',[VpsController::class,'reboot']);
});

//User
Route::get('/users', [UserController::class,'index']);


Route::apiResource('distributions', DistributionController::class);

Route::apiResource('os', OSController::class);

