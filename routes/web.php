<?php

use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

Route::prefix('contract')->group(function () {
    Route::get('/', [ContractController::class, 'index'])->name('contract.index');
    Route::get('/create', [ContractController::class, 'create'])->name('contract.create');
});
