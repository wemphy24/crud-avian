<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterSalesController;
use App\Http\Controllers\MasterTokoController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Master Toko
Route::get('master-toko/template', [MasterTokoController::class, 'downloadTemplate'])->name('master-toko.template');
Route::get('master-toko/export/pdf', [MasterTokoController::class, 'exportPdf'])->name('master-toko.export.pdf');
Route::resource('master-toko', MasterTokoController::class);
Route::post('master-toko/import', [MasterTokoController::class, 'import'])->name('master-toko.import');

// Master Sales
Route::get('master-sales/template', [MasterSalesController::class, 'downloadTemplate'])->name('master-sales.template');
Route::get('master-sales/export/pdf', [MasterSalesController::class, 'exportPdf'])->name('master-sales.export.pdf');   // ← tambah
Route::resource('master-sales', MasterSalesController::class);
Route::post('master-sales/import', [MasterSalesController::class, 'import'])->name('master-sales.import');

// Transaksi
Route::get('transaksi/template', [TransaksiController::class, 'downloadTemplate'])->name('transaksi.template');
Route::get('transaksi/export/pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.export.pdf');   // ← tambah
Route::resource('transaksi', TransaksiController::class);
Route::post('transaksi/import', [TransaksiController::class, 'import'])->name('transaksi.import');

// Laporan
Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
Route::get('laporan/export/semua', [LaporanController::class, 'exportSemua'])->name('laporan.export.semua');
Route::get('laporan/export/area', [LaporanController::class, 'exportPerArea'])->name('laporan.export.area');
Route::get('laporan/export/sales', [LaporanController::class, 'exportPerSales'])->name('laporan.export.sales');
