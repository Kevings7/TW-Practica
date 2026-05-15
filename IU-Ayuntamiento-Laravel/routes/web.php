<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidenciaController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');

Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');
Route::get('/incidencias/{incidencia}', [IncidenciaController::class, 'show'])->name('incidencias.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/reportar', [IncidenciaController::class, 'create'])->name('incidencias.create');
    Route::post('/reportar', [IncidenciaController::class, 'store'])->name('incidencias.store');

    Route::get('/mis-incidencias', [IncidenciaController::class, 'mine'])->name('incidencias.mine');

    Route::get('/panel-tecnico', [IncidenciaController::class, 'panelTecnico'])->name('tecnico.panel');
    Route::post('/panel-tecnico/{incidencia}/estado', [IncidenciaController::class, 'cambiarEstado'])->name('tecnico.estado');
});