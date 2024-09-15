<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\DummyController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PemilihController;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', [UserController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::get('/', [IndexController::class, 'index'])->middleware(['auth', 'cors']);
Route::get('/pemilih', [PemilihController::class, 'index'])->middleware(['auth', 'cors']);

Route::get('/data-index', [IndexController::class, 'indexData'])->middleware('auth');
Route::get('/details/{nama_kecamatan}', [IndexController::class, 'detailsKecamatan'])->middleware('auth');
Route::get('/details/{nama_kecamatan}/{nama_kelurahan}', [IndexController::class, 'detailsKelurahan'])->middleware('auth');
Route::get('/Admin-Dashboard', [ViewController::class, 'DashboardAdmin']);
// Route::get('/Data-Pemilih', [ViewController::class, 'DataPemilih']);
