<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\InstallmentScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('contract')->group(function () {
    Route::get('/', [ContractController::class, 'index'])->name('contract.index');
    Route::post('/', [ContractController::class, 'store'])->name('contract.store');
    Route::get('/create', [ContractController::class, 'create'])->name('contract.create');
});

Route::prefix('installment-schedule')->group(function () {
    Route::get('/', [InstallmentScheduleController::class, 'index'])->name('installment-schedule.index');
});
