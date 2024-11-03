<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\exporcontroller;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\AywaController;
use App\Http\Controllers\AmlyatController;


Route::get('/', [exporcontroller::class, 'home']);
Route::get('/lab', [exporcontroller::class, 'lab'])->name('lab');
Route::get('/ewaa', [exporcontroller::class, 'ewaa'])->name('ewaa');
Route::get('/eyadat', [exporcontroller::class, 'eyadat'])->name('eyadat');
Route::get('/amlyat', [exporcontroller::class, 'amlyat'])->name('amlyat');


Route::get('/download-excel', [exporcontroller::class, 'downloadExcel'])->name('downloadExcel');
Route::get('/aywa-excel', [exporcontroller::class, 'aywaexcel'])->name('aywaexcel');
Route::get('/clinc-excel', [exporcontroller::class, 'clinicExport'])->name('clinicExport');
Route::post('/', [exporcontroller::class, 'import'])->name('import');




Route::get('/search', [exporcontroller::class, 'search'])->name('search.route');
Route::get('/download', [exporcontroller::class, 'download'])->name('download.route');



Route::get('/clinicsearch', [ClinicController::class, 'clinicsearch'])->name('clinicsearch');
Route::get('/clinicdownload', [ClinicController::class, 'clinicdownload'])->name('clinicdownload');


Route::get('/AywaSearch', [AywaController::class, 'AywaSearch'])->name('AywaSearch');
Route::get('/AywaDownload', [AywaController::class, 'AywaDownload'])->name('AywaDownload');


Route::get('/amlyat/search', [AmlyatController::class, 'amlyatSearch'])->name('amlyatSearch');
Route::get('/amlyatDownload', [AmlyatController::class, 'amlyatDownload'])->name('amlyatDownload');
