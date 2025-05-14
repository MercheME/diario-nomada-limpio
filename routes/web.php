<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\DiarioController;
use App\Http\Controllers\DiarioImagenController;
use App\Http\Controllers\FriendshipCrontroller;
use App\Http\Controllers\ProyectoImagenController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');  // Si está autenticado, va al home
    }

    return redirect()->route('login'); // Si no está autenticado, va al login
});

// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('store');
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store'])->name('login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Rutas para gestión de solicitudes de amistad
// Route::get('/amigos', [FriendshipCrontroller::class, 'mostrarAmigos'])->name('amistad.amigos')->middleware('auth');
// Route::get('/solicitudes', [FriendshipCrontroller::class, 'mostrarSolicitudesPendientes'])->name('amistad.solicitudes')->middleware('auth');
// Route::post('/amigos/{user}', [FriendshipCrontroller::class, 'enviarSolicitudAmistad'])->name('amistad.enviar')->middleware('auth');
// Route::post('/amistad/{friendship}/aceptar', [FriendshipCrontroller::class, 'aceptarSolicitudAmistad'])->name('amistad.aceptar')->middleware('auth');
// Route::post('/amistad/{friendship}/rechazar', [FriendshipCrontroller::class, 'rechazarSolicitudAmistad'])->name('amistad.rechazar')->middleware('auth');
// Rutas para solicitudes de amistad
Route::post('/solicitudes/{user}', [FriendshipCrontroller::class, 'enviarSolicitudAmistad'])->name('solicitudes.enviar');
Route::post('/solicitudes/aceptar/{friendship}', [FriendshipCrontroller::class, 'aceptarSolicitudAmistad'])->name('solicitudes.aceptar');
Route::post('/solicitudes/rechazar/{friendship}', [FriendshipCrontroller::class, 'rechazarSolicitudAmistad'])->name('solicitudes.rechazar');
Route::delete('/amigos/{user}', [FriendshipCrontroller::class, 'eliminarAmigo'])->name('amigos.eliminar');


// Rutas para mostrar amigos y solicitudes
Route::get('/amigos', [FriendshipCrontroller::class, 'mostrarAmigos'])->name('amigos.index');
Route::get('/solicitudes', [FriendshipCrontroller::class, 'mostrarSolicitudesPendientes'])->name('solicitudes.index');

// Diarios
Route::get('/home', [DiarioController::class, 'home'])->name('home')->middleware('auth');
Route::get('/diarios', [DiarioController::class, 'index'])->middleware('auth')->name('diarios.index');
Route::get('/diarios/publicados', [DiarioController::class, 'publicados'])->middleware('auth')->name('diariosPublicados');

Route::get('/diarios/crear', [DiarioController::class, 'create'])->middleware('auth')->name('diarios.create');
Route::post('/diarios', [DiarioController::class, 'store'])->middleware('auth')->name('diarios.store');
Route::get('/diarios/{slug}', [DiarioController::class, 'show'])->name('diarios.show');
Route::get('/diarios/{slug}/editar', [DiarioController::class, 'edit'])->middleware('auth')->name('diarios.edit');
Route::put('/diarios/{slug}', [DiarioController::class, 'update'])->middleware('auth')->name('diarios.update');
Route::delete('/diarios/{slug}', [DiarioController::class, 'destroy'])->middleware('auth')->name('diarios.destroy');
Route::post('/diarios/{slug}/imagenes', [DiarioController::class, 'agregarImagen'])->name('diarios.agregarImagen');
Route::delete('/imagenes/{imagen}', [DiarioImagenController::class, 'destroy'])->name('diario-imagenes.destroy');
Route::patch('/diario-imagenes/{imagen}/establecer-principal', [DiarioImagenController::class, 'establecerPrincipal'])->name('diario-imagenes.establecerPrincipal');


// Imágenes de diarios
Route::post('/diarios/{diario}/imagenes', [DiarioImagenController::class, 'store']);
Route::delete('/diarios/imagenes/{id}', [DiarioImagenController::class, 'destroy']);


// Mapa para diarios
Route::get('/mapa-diarios', [\App\Http\Controllers\DiarioController::class, 'mapa'])->name('diarios.mapa');

//Rutas para destinos
Route::get('/diarios/{diario}/destinos/crear', [DestinoController::class, 'create'])->name('destinos.create');
Route::post('/diarios/{diario}/destinos', [DestinoController::class, 'store'])->name('destinos.store');
// Route::get('/diarios/{diario}/destinos/{slug}', [DestinoController::class, 'show'])->name('destinos.show');


// Proyectos comunitarios
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
Route::get('/proyectos/{id}', [ProyectoController::class, 'show']);
Route::post('/proyectos', [ProyectoController::class, 'store']);
Route::put('/proyectos/{id}', [ProyectoController::class, 'update']);
Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy']);

// Imágenes de proyectos
Route::post('/proyectos/{proyecto}/imagenes', [ProyectoImagenController::class, 'store']);
Route::delete('/proyectos/imagenes/{id}', [ProyectoImagenController::class, 'destroy']);
