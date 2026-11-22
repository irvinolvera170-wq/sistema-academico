<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MiInformacionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Redirige según el rol (el nombre "home" lo usa Laravel para los usuarios ya autenticados)
    Route::get('/home', function () {
        return auth()->user()->esProfesor()
            ? redirect()->route('alumnos.index')
            : redirect()->route('alumno.informacion');
    })->name('home');

    // Solo alumno: consulta de su propia información
    Route::get('/mi-informacion', MiInformacionController::class)
        ->middleware('role:alumno')
        ->name('alumno.informacion');

    // Solo profesor: administración de alumnos
    Route::middleware('role:profesor')
        ->prefix('alumnos')->name('alumnos.')
        ->where(['alumno' => '[0-9]+'])
        ->group(function () {
            Route::get('/', [AlumnoController::class, 'index'])->name('index');
            Route::get('/crear', [AlumnoController::class, 'create'])->name('create');
            Route::post('/', [AlumnoController::class, 'store'])->name('store');
            Route::get('/{alumno}/editar', [AlumnoController::class, 'edit'])->name('edit');
            Route::put('/{alumno}', [AlumnoController::class, 'update'])->name('update');
            Route::delete('/{alumno}', [AlumnoController::class, 'destroy'])->name('destroy');
        });
});