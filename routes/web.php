<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ComplianceDocumentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Models\Client;
use App\Http\Controllers\ActivityLogController;

Route::get('/', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard',
    [DashboardController::class,'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::resource('clients', ClientController::class)->middleware('auth');

Route::resource('portfolios', PortfolioController::class)->middleware('auth');

Route::middleware('auth')->group(function(){

    Route::get('/clients/{client}/compliance',
        [ComplianceDocumentController::class,'index'])
        ->name('compliance.index');

    Route::get('/compliance/create',
        [ComplianceDocumentController::class,'create'])
        ->name('compliance.create');

    Route::post('/compliance',
        [ComplianceDocumentController::class,'store'])
        ->name('compliance.store');

    Route::get('/portfolios/{portfolio}/transactions',
        [TransactionController::class,'index'])
        ->name('transactions.index');

    Route::get('/transactions/create',
        [TransactionController::class,'create'])
        ->name('transactions.create');

    Route::post('/transactions',
        [TransactionController::class,'store'])
        ->name('transactions.store');

    Route::get('/reports',
        [ReportController::class,'index'])
        ->name('reports.index');

    Route::get('/reports/investor/{client}',
        [ReportController::class,'investorStatement'])
        ->name('reports.investor');

    Route::get('/reports/investor/{client}/download',
        [ReportController::class,'downloadStatement'])
        ->name('reports.download');

});

Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/activity-logs',
        [ActivityLogController::class,'index'])
        ->name('activity.index');

});

Route::post('/logout', [AuthController::class, 'logout']);