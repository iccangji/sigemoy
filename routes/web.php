<?php

use App\Http\Controllers\DummyController;
use App\Http\Controllers\GandaController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InvalidController;
use App\Http\Controllers\KpuController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\PenanggungJawabController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', [UserController::class, 'auth'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.auth');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', [IndexController::class, 'index'])->middleware(['auth', 'cors'])->name('dashboard');
Route::get('/data-index', [IndexController::class, 'indexData'])->middleware(['auth', 'cors'])->name('dashboard.data');

Route::resource('/pemilih', PemilihController::class)->only([
    'index',
    'store',
    'update',
    'destroy'
])->middleware(['auth']);
Route::get('/pemilih-lokasi/{id}', [PemilihController::class, 'location'])->middleware(['auth'])->name('pemilih.location');
Route::post('/pemilih-import', [PemilihController::class, 'importData'])->middleware(['auth'])->name('pemilih.import');

Route::resource('/data-user', UserController::class)->only([
    'index',
    'store',
    'update',
    'destroy'
]);

Route::resource('/data-kpu', KpuController::class)->only([
    'index',
    'store',
    'update',
    'destroy'
])->middleware(['auth']);
Route::post('/kpu-import', [KpuController::class, 'importData'])->middleware(['auth'])->name('kpu.import');

Route::get('/data-ganda', [GandaController::class, 'index'])->middleware(['auth', 'cors'])->name('ganda.index');
Route::delete('/data-ganda/{id}', [GandaController::class, 'destroy'])->middleware(['auth', 'cors'])->name('ganda.destroy');

Route::get('/data-invalid', [InvalidController::class, 'index'])->middleware(['auth', 'cors'])->name('invalid.index');

Route::get('/penanggung-jawab', [PenanggungJawabController::class, 'index'])->middleware(['auth', 'cors'])->name('pj.index');;


// Route::get('/data-kpu', [KpuController::class, 'index'])->middleware(['auth']);




// Route::get('/pemilih', [PemilihController::class, 'index'])->middleware(['auth']);
// Route::post('/pemilih', [PemilihController::class, 'store'])->middleware(['auth']);
// Route::delete('/pemilih/{id}', [PemilihController::class, 'destroy'])->middleware(['auth']);


// //
// Route::get('/pemilih-data', [PemilihController::class, 'getPemilihData']);
// //

// Route::get('/details/{nama_kecamatan}', [IndexController::class, 'detailsKecamatan'])->middleware('auth');
// Route::get('/details/{nama_kecamatan}/{nama_kelurahan}', [IndexController::class, 'detailsKelurahan'])->middleware('auth');
// Route::get('/Admin-Dashboard', [ViewController::class, 'DashboardAdmin']);
// Route::get('/Data-Pemilih', [ViewController::class, 'DataPemilih']);
