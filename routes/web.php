<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ProcedureTypeController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Breeze Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ciudadanos
    Route::resource('citizens', CitizenController::class);

    // Tipos de trámite
    Route::resource('procedure-types', ProcedureTypeController::class);

    // Trámites (CRUD normal)
    Route::resource('procedures', ProcedureController::class);

    // ✅ Estatus rápido desde la tabla
    Route::patch('procedures/{procedure}/status', [ProcedureController::class, 'updateStatus'])->name('procedures.status');
});

require __DIR__.'/auth.php';
