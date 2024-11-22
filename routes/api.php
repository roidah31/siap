<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProfileController;

Route::get('/gedung', [GedungController::class, 'index'])->name('gedung');
Route::get('/get-nama-gedung', [GedungController::class, 'getNamaGedung']);
Route::get('/get-kode-gedung', [GedungController::class, 'getKodeGedung']);
Route::get('/get-nama-unit', [ProfileController::class, 'getNamaUnit']);
Route::get('/get-kode-unit', [GedungController::class, 'getKodeUnit']);

Route::get('/get-units', [UnitController::class, 'getUnits']);


Route::get('/get-nama-barang', [AssetController::class, 'getNamaBarang']);
Route::get('/get-unit', [AssetController::class, 'getUnit']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
