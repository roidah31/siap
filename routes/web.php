<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function (){
    return view('home');
});
Route::get('/depan', [App\Http\Controllers\DepanController::class, 'home'])->name('depan');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/getLoginMitra/{username_login}', [LoginController::class,'login']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('dashboard',[App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
//Profile section
Route::get('/profile/ubah', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.ubah');
Route::POST('/profile/update', [App\Http\Controllers\ProfileController::class,'update'])->name('profile.update');
Route::get('/profile/password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.password');
Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');


//Process Transaction
Route::post('/barangubah', [App\Http\Controllers\BarangController::class, 'update'])->name('barangubah');
Route::controller(App\Http\Controllers\BarangController::class)->group(function() {
    Route::get('/barang/lihat', 'index')->name('barang.index');
	Route::get('/barang/tambah','create')->name('barang.tambah');
    Route::get('/barang/edit/{id}','edit')->name('barang.edit');
	Route::post('/barang/store','store')->name('barang.store');
    Route::post('/barang/hapus/{id}','destroy')->name('barang.hapus');
});
Route::controller(App\Http\Controllers\GedungController::class)->group(function() {
    Route::get('/gedung/lihat', 'index')->name('gedung.index');
	Route::post('/gedung/store','store')->name('gedung.store');
    Route::get('/gedung/tambah','create')->name('gedung.tambah');
    Route::post('/gedung/destroy/{id}','destroy')->name('gedung.destroy');
    Route::post('/gedung/update','update')->name('gedung.update');
    Route::get('/gedung/edit/{id}', 'edit')->name('gedung.edit');

    // Route::post('/store', [GedungController::class, 'store'])->name('gedung.store');
    // Route::post('/update/{id}', [GedungController::class, 'update'])->name('gedung.update');
    // Route::delete('/destroy/{id}', [GedungController::class, 'destroy'])->name('gedung.destroy');
    
});

Route::controller(App\Http\Controllers\SopController::class)->group(function() {
    Route::get('/sop/lihat', 'index')->name('sop.index');
	Route::post('/sop/store','store')->name('sop.store');
    Route::get('/sop/tambah','create')->name('sop.tambah');
    Route::post('/sop/destroy/{id}','destroy')->name('sop.destroy');
    Route::post('/sop/update', 'update')->name('sop.update');
    Route::get('/sop/get-download-url/{id}', 'getDownloadUrl')->name('sop.get-download-url');
    Route::get('/sop/download/{token}', 'download')->name('sop.download');
});

Route::controller(App\Http\Controllers\UnitController::class)->group(function() {
    Route::get('/unit/lihat', 'index')->name('unit.index');
	Route::post('/unit/store','store')->name('unit.store');
    Route::get('/unit/tambah','create')->name('unit.tambah');
    Route::post('/unit/hapus/{id}','destroy')->name('unit.hapus');
    Route::post('/unit/update','update')->name('unit.update');
});

Route::controller(App\Http\Controllers\AssetController::class)->group(function() {
    Route::get('/aset/lihat', 'index')->name('aset.index');
	Route::post('/aset/store','store')->name('aset.store');
    Route::get('/aset/tambah','create')->name('aset.tambah');
    Route::post('/aset/delete/{id}','destroy')->name('aset.destroy');
    Route::put('/aset/update', 'update')->name('aset.update');
    Route::get('/get-lantai',  'getLantai')->name('get.lantai');
    Route::get('/get-units', 'getUnitByLantai')->name('get.units');

    // laporan 
    Route::get('/aset/laporan', 'laporan')->name('aset.laporan');
    Route::get('/aset/laporan_data', 'record')->name('aset.laporan_data');
    Route::post('/aset/laporan',  'laporan')->name('aset.laporan');
    Route::get('/aset/export-pdf',  'exportPdf')->name('aset.export.pdf');

});//end Asset
});

