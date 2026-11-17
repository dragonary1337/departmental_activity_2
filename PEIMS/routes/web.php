<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'equipment.index' : 'login'));

Route::get('/dashboard', function () {
    return redirect()->route('equipment.index');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('equipment', EquipmentController::class);
    Route::get('/reports', [EquipmentReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/pdf', [EquipmentReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('/reports/export/excel', [EquipmentReportController::class, 'excel'])->name('reports.excel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
