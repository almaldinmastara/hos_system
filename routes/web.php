<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\exporcontroller;



Route::get('/', [exporcontroller::class, 'home']);
Route::get('/lab', [exporcontroller::class, 'lab'])->name('lab');
Route::get('/ewaa', [exporcontroller::class, 'ewaa'])->name('ewaa');
Route::get('/eyadat', [exporcontroller::class, 'eyadat'])->name('eyadat');
Route::get('/amlyat', [exporcontroller::class, 'amlyat'])->name('amlyat');


Route::get('/download-excel', [exporcontroller::class, 'downloadExcel'])->name('downloadExcel');
Route::get('/aywa-excel', [exporcontroller::class, 'aywaexcel'])->name('aywaexcel');
Route::get('/clinc-excel', [exporcontroller::class, 'clinicExport'])->name('clinicExport');
Route::post('/', [exporcontroller::class, 'import'])->name('import');


