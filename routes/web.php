<?php

use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\DiarioComunidadController;
use App\Http\Controllers\DiarioController;
use App\Http\Controllers\DiarioImagenController;
use App\Http\Controllers\DiarioTagController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('diarios.index'); // Si está autenticado, va al listado de diarios
    }

    return redirect()->route('login'); // Si no está autenticado, va al login
});

// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('store');
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store'])->name('login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Diarios
Route::get('/diarios', [DiarioController::class, 'index'])->middleware('auth')->name('diarios.index');
Route::get('/diarios/crear', [DiarioController::class, 'create'])->middleware('auth')->name('diarios.create');
Route::post('/diarios', [DiarioController::class, 'store'])->middleware('auth')->name('diarios.store');
Route::get('/diarios/{slug}', [DiarioController::class, 'show'])->name('diarios.show');
Route::get('/diarios/{slug}/editar', [DiarioController::class, 'edit'])->middleware('auth')->name('diarios.edit');
Route::put('/diarios/{slug}', [DiarioController::class, 'update'])->middleware('auth')->name('diarios.update');
Route::delete('/diarios/{slug}', [DiarioController::class, 'destroy'])->middleware('auth')->name('diarios.destroy');

// Imágenes de diarios
Route::post('/diarios/{diario}/imagenes', [DiarioImagenController::class, 'store']);
Route::delete('/diarios/imagenes/{id}', [DiarioImagenController::class, 'destroy']);

// Tags
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
Route::delete('/tags/{id}', [TagController::class, 'destroy']);

// Comunidades
Route::get('/comunidades', [ComunidadController::class, 'index']);
Route::get('/comunidades/{id}', [ComunidadController::class, 'show']);
Route::post('/comunidades', [ComunidadController::class, 'store']);
Route::put('/comunidades/{id}', [ComunidadController::class, 'update']);
Route::delete('/comunidades/{id}', [ComunidadController::class, 'destroy']);

// Diario <-> Tags (pivot)
Route::post('/diarios/{diario}/tags', [DiarioTagController::class, 'attach']);
Route::delete('/diarios/{diario}/tags/{tag}', [DiarioTagController::class, 'detach']);

// Diario <-> Comunidades (pivot)
Route::post('/diarios/{diario}/comunidades', [DiarioComunidadController::class, 'attach']);
Route::delete('/diarios/{diario}/comunidades/{comunidad}', [DiarioComunidadController::class, 'detach']);
