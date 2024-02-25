<?php

use App\Http\Controllers\OpenStack\AuthController;
use App\Http\Controllers\OpenStack\FlavorInStackController;
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
//Route::get('ajax2/test',  [TestController::class, 'index']);
//Route::get('ajax2/test2',  [TestController::class, 'index2']);
//Route::post('ajax2/test3', [TestController::class, 'index3'])->name('store.chosen.flavor');
