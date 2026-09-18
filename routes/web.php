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
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AodFormController;

Route::get('/', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard',
    [DashboardController::class,'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/settings',
    [SettingsController::class,'index'])
    ->name('settings.index')
    ->middleware('auth');

Route::get('/aod-forms',
    [AodFormController::class,'index'])
    ->name('aod.index')
    ->middleware('auth');

// Relationship Officer + Admin: Clients, Portfolios, Transactions
Route::middleware(['auth','role:admin,relationship_officer'])->group(function(){

    Route::resource('clients', ClientController::class);

    Route::resource('portfolios', PortfolioController::class);

    Route::get('/portfolios-overview',
        [PortfolioController::class,'all'])
        ->name('portfolios.all');

    Route::get('/portfolios/{portfolio}/transactions',
        [TransactionController::class,'index'])
        ->name('transactions.index');

    Route::get('/transactions/create',
        [TransactionController::class,'create'])
        ->name('transactions.create');

    Route::post('/transactions',
        [TransactionController::class,'store'])
        ->name('transactions.store');

});

// Compliance Officer + Admin: Compliance
Route::middleware(['auth','role:admin,compliance'])->group(function(){

    Route::get('/clients/{client}/compliance',
        [ComplianceDocumentController::class,'index'])
        ->name('compliance.index');

    Route::get('/compliance',
        [ComplianceDocumentController::class,'all'])
        ->name('compliance.all');

    Route::get('/compliance/create',
        [ComplianceDocumentController::class,'create'])
        ->name('compliance.create');

    Route::post('/compliance',
        [ComplianceDocumentController::class,'store'])
        ->name('compliance.store');

    Route::post('/compliance/{document}/approve',
        [ComplianceDocumentController::class,'approve'])
        ->name('compliance.approve');

    Route::post('/compliance/{document}/reject',
        [ComplianceDocumentController::class,'reject'])
        ->name('compliance.reject');

});

// Finance Officer + Admin: Reports
Route::middleware(['auth','role:admin,finance'])->group(function(){

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

// Admin only: Activity Logs
Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/activity-logs',
        [ActivityLogController::class,'index'])
        ->name('activity.index');

});

Route::post('/logout', [AuthController::class, 'logout']);