<?php

use App\Http\Controllers\OpenStack\AuthController;
use App\Http\Controllers\OpenStack\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('ajax/test',  [AuthController::class, 'test']);
Route::get('ajax2/test',  [TestController::class, 'index']);
Route::get('ajax2/test2',  [TestController::class, 'index2']);
