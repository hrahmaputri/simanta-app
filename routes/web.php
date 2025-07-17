<?php

use Illuminate\Support\Facades\Route;

//route awal
Route::get('/', [\App\Http\Controllers\RoleController::class, 'home']);

Route::middleware('auth')->group(function () {
    //route user
    Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
        Route::get('/logout', 'logout');
        Route::get('/editpas', 'editpass');
        Route::get('/changepass', 'changepass');
    });

    Route::get('/dapeg', [\App\Http\Controllers\DataController::class, 'index']);
    Route::get('/datanilai/{id}', [\App\Http\Controllers\Perhitungan::class, 'index'])->name('nilaiPegawai');
    Route::post('/inputnilai', [\App\Http\Controllers\DataController::class, 'inputNilai']);

    //sinkron pegawai
    Route::get('/sinkronisasi', [\App\Http\Controllers\SinkronData::class, 'index']);
    Route::get('/apiAll', [\App\Http\Controllers\SinkronData::class, 'apiAllDapeg'])->name('semuaDapeg');
    Route::get('/sinkronPegawai', [\App\Http\Controllers\SinkronData::class, 'apiPilihDapeg'])->name('viewSatuPegawai');
    Route::get('/apiSatupeg/{id}', [\App\Http\Controllers\SinkronData::class, 'apiSatuDapeg'])->name('satuPegawai');

    Route::get('/inputpegawai', [\App\Http\Controllers\DataController::class, 'inputPegawai'])->name('tambahPegawai');
    Route::post('/filterPegawai', [\App\Http\Controllers\DataController::class, 'filterPegawai']);
    Route::get('/pilihPegawai/{id_pegawai}', [\App\Http\Controllers\DataController::class, 'pilihPegawai'])->name('pilihPegawai');
    Route::get('/hapusPegawai/{id}', [\App\Http\Controllers\DataController::class, 'hapusPegawai'])->name('hapusPegawai');

    Route::get('/profil/{id}/ind/{ind}', [\App\Http\Controllers\DataController::class, 'cekPegawai'])->name('cekPegawai');
    Route::get('/lihatfile/{id_type}/{id_peg}/{id_riw}', [\App\Http\Controllers\DataController::class, 'lihatFile'])->name('lihatFile');

    Route::get('/kompetensi', [\App\Http\Controllers\KompetensiController::class, 'index']);
    Route::post('/filterpegkomp', [\App\Http\Controllers\KompetensiController::class, 'filterPegKomp']);
    Route::get('/kompeg/{id}', [\App\Http\Controllers\KompetensiController::class, 'KompetensiPegawai'])->name('kompeg');

    Route::get('/tambahkompeg/{id}/{id_kompeg}', [\App\Http\Controllers\KompetensiController::class, 'tambahKompetensi'])->name('tambahKompetensi');
    Route::post('/inputkompeg', [\App\Http\Controllers\KompetensiController::class, 'inputKompeg']);
    Route::get('/hapuskompeg/{id}/{id_kompeg}', [\App\Http\Controllers\KompetensiController::class, 'hapusKompeg'])->name('hapusKompeg');

    Route::get('/simpelData', [\App\Http\Controllers\SimpelController::class, 'addData'])->name('simpelData');
    Route::get('/asesData', [\App\Http\Controllers\SimpelController::class, 'addDataAses'])->name('asesData');

    Route::get('/charts', [\App\Http\Controllers\ReportController::class, 'index']);

    Route::post('/pilihtarget', [\App\Http\Controllers\JabatanTarget::class, 'pilihTarget']);
    Route::get('/target', [\App\Http\Controllers\JabatanTarget::class, 'index']);
    Route::post('/addjabtarget', [\App\Http\Controllers\JabatanTarget::class, 'addTarget']);
    Route::get('/target/{id}', [\App\Http\Controllers\JabatanTarget::class, 'hapusTarget'])->name('hapusTarget');
    Route::get('/generate/{id}', [\App\Http\Controllers\JabatanTarget::class, 'generate'])->name('generate');

    Route::get('/indikator', [\App\Http\Controllers\IndikatorController::class, 'index']);
    Route::get('/ubahindikator', [\App\Http\Controllers\IndikatorController::class, 'editIndikator']);

    //route AJAX
    Route::get('/dataset', [\App\Http\Controllers\ReportController::class, 'getData']);
    Route::get('/datapoin', [\App\Http\Controllers\DataController::class, 'getPoin']);
});

Route::middleware('guest')->group(function () {
    Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login');
    });
});
