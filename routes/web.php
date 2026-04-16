<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    // Purchases
    Route::get('/purchases',  [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');

    // Sales
    Route::get('/sales',  [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    // Stock
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

    // Reports (CSV exports)
    Route::get('/reports/purchases/csv', [ReportController::class, 'purchasesCsv'])->name('reports.purchases.csv');
    Route::get('/reports/sales/csv',     [ReportController::class, 'salesCsv'])->name('reports.sales.csv');
    Route::get('/reports/stock/csv',     [ReportController::class, 'stockCsv'])->name('reports.stock.csv');
});