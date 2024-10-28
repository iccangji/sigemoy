<?php

use App\Http\Controllers\DummyController;
use App\Http\Controllers\GandaController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InvalidController;
use App\Http\Controllers\KpuController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\PenanggungJawabController;
use App\Http\Controllers\RekapDataController;
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

Route::get('/', [IndexController::class, 'index'])->middleware(['auth', 'cors', 'no-cache'])->name('dashboard');
Route::get('/data-index', [IndexController::class, 'indexData'])->middleware(['auth', 'cors'])->name('dashboard.data');

Route::resource('/pemilih', PemilihController::class)->only([
    'index',
    'store',
    'update',
    'destroy'
])->middleware(['auth']);

Route::get('/pemilih/filter', [PemilihController::class, 'cari'])->middleware(['auth', 'cors'])->name('pemilih.filter');
Route::post('/pemilih/filter', [PemilihController::class, 'cari'])->middleware(['auth', 'cors'])->name('pemilih.filter');

Route::get('/pemilih-lokasi/{id}', [PemilihController::class, 'location'])->middleware(['auth'])->name('pemilih.location');
Route::post('/pemilih-import', [PemilihController::class, 'importData'])->middleware(['auth'])->name('pemilih.import');
Route::get('/pemilih-export', [PemilihController::class, 'exportData'])->middleware(['auth'])->name('pemilih.export');

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

Route::get('/data-kpu/filter', [KpuController::class, 'cari'])->middleware(['auth', 'cors'])->name('kpu.filter');
Route::post('/data-kpu/filter', [KpuController::class, 'cari'])->middleware(['auth', 'cors'])->name('kpu.filter');

Route::post('/kpu-import', [KpuController::class, 'importData'])->middleware(['auth'])->name('kpu.import');
Route::get('/kpu-truncate', [KpuController::class, 'clearData'])->middleware(['auth'])->name('kpu.truncate');

Route::get('/data-ganda', [GandaController::class, 'index'])->middleware(['auth', 'cors'])->name('ganda.index');
Route::post('/data-ganda', [GandaController::class, 'store'])->middleware(['auth'])->name('ganda.store');
Route::delete('/data-ganda/{id}', [GandaController::class, 'destroy'])->middleware(['auth', 'cors'])->name('ganda.destroy');

Route::get('/data-invalid', [InvalidController::class, 'index'])->middleware(['auth', 'cors'])->name('invalid.index');
Route::delete('/data-invalid/{id}', [InvalidController::class, 'destroy'])->middleware(['auth', 'cors'])->name('invalid.destroy');
Route::post('/data-invalid/insert', [InvalidController::class, 'store'])->middleware(['auth', 'cors'])->name('invalid.store');
Route::put('/data-invalid/{id}', [InvalidController::class, 'update'])->middleware(['auth', 'cors'])->name('invalid.update');
Route::get('/data-invalid/sync', [InvalidController::class, 'sync'])->middleware(['auth', 'cors'])->name('invalid.sync');
Route::get('/data-invalid/validate', [InvalidController::class, 'pemilihValidate'])->middleware(['auth', 'cors'])->name('invalid.validate');

Route::get('/penanggung-jawab', [PenanggungJawabController::class, 'index'])->middleware(['auth', 'cors'])->name('pj.index');;
Route::get('/rekap-data', [RekapDataController::class, 'index'])->middleware(['auth'])->name('rekap.index');
Route::get('/rekap-data-export', [RekapDataController::class, 'exportData'])->middleware(['auth'])->name('rekap.export');
Route::get('/rekap-data-suggestion', [RekapDataController::class, 'suggestion'])->middleware(['auth'])->name('rekap.suggestion');


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
