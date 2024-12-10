<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompraController;

// Ruta del dashboard
Route::get('/', function () {
    return view('dashboard');
});

// Rutas públicas (sin autenticación requerida)
Route::get('actividades/reporte', [ActividadController::class, 'generarReporte'])->name('actividades.reporte');
Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');
Route::post('/actividades', [ActividadController::class, 'store'])->name('actividades.store');
Route::get('/actividades/{actividad}', [ActividadController::class, 'show'])->name('actividades.show');
Route::put('/actividades/{actividad}', [ActividadController::class, 'update'])->name('actividades.update');
Route::delete('/actividades/{actividad}', [ActividadController::class, 'destroy'])->name('actividades.destroy');
Route::get('/actividades/{actividad}/pdf', [ActividadController::class, 'generatePdf'])->name('actividades.pdf');
Route::get('/departamentos/sede/{sede_id}', [ActividadController::class, 'getDepartamentosPorSede']);
Route::get('/reporte-editor', [ActividadController::class, 'reporteEditor'])->name('reporte.editor');
Route::post('/reporte-config', [ActividadController::class, 'updateReporteConfig'])->name('reporte.update-config');

// Rutas de productos
Route::resource('products', ProductController::class);

// Rutas de clientes
Route::resource('customers', CustomerController::class);

// Rutas de órdenes
Route::resource('orders', OrderController::class);

// Rutas de reportes
Route::prefix('reports')->group(function () {
    Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
});

// Rutas de autenticación
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::middleware(['auth'])->group(function () {
    // Otras rutas que requieran autenticación
});

// Rutas de compras
Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');
Route::put('/compras/{compra}', [CompraController::class, 'update'])->name('compras.update');
Route::delete('/compras/{compra}', [CompraController::class, 'destroy'])->name('compras.destroy');

