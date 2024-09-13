<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\DummyController;

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

Route::get('/login', [ViewController::class, 'login'])->name('login');
Route::get('/Admin-Dashboard', [ViewController::class, 'dashboard'])->name('Admin-Dashboard');
Route::get('/dummy-users', [DummyController::class, 'generateDummyUsers']);


Route::middleware('auth')->group(function () {


});