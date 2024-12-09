<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LaporanController::class)->group(function () {
    Route::get('/laporan', 'laporan')->name('laporan.pencatatan');
    Route::get('/pencatatan-entry', 'create')->name('laporan.pencatatan-entry'); 
    Route::post('/pencatatan-entry', [LaporanController::class, 'store'])->name('pencatatan.store');
    Route::get('pencatatan/{id_laporan}/edit', [LaporanController::class, 'edit'])->name('pencatatan.edit');
    Route::put('pencatatan/{id_laporan}', [LaporanController::class, 'update'])->name('pencatatan.update');
    Route::get('pencatatan/{id_laporan}/hapus', [LaporanController::class, 'delete'])->name('pencatatan.hapus');
    Route::delete('pencatatan/{id_laporan}/destroy', [LaporanController::class, 'destroy'])->name('pencatatan.destroy');
    Route::get('/pencatatan-cetak', [LaporanController::class, 'cetak'])->name('pencatatan.cetak');
});
