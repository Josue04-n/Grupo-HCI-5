<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas de Exportación de Backlog (UX AI)
Route::middleware(['auth'])->group(function () {
    Route::post('/backlog/export/md/{prueba}', [App\Http\Controllers\BacklogExportController::class, 'exportMarkdown'])->name('backlog.export.md');
    Route::post('/backlog/export/pdf/{prueba}', [App\Http\Controllers\BacklogExportController::class, 'exportPdf'])->name('backlog.export.pdf');
});
