<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MascotasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;



Route::view('/', 'welcome')->name('welcome');
Route::view('/academia', 'academia')->name('academia');
Route::view('/contacto', 'contacto')->name('contacto');
Route::view('/hobbies', 'hobbies')->name('hobbies');
Route::view('/iniciar', '/administrador/iniciar')->name('iniciar');
Route::view('/admin', '/administrador/admin')->name('admin');
Route::view('/solicitudes', '/administrador/solicitudes')->name('solicitudes');
Route::view('/aceptados', '/administrador/aceptados')->name('aceptados');
Auth::routes();


//admin
Route::view('/mascotas', '/administrador/mascotas/mascotas')->name('mascotas');
Route::view('/mascotas/registro', '/administrador/mascotas/registro_mascotas')->name('registro');
Route::get('/mascotas/listado',[MascotasController::class,'listado'])->name('listado');
Route::get('/mascotas/formulario',[MascotasController::class,'formulario']);
Route::post('/mascotas/nuevo',[MascotasController::class,'crear']);

//cuenta
Route::get('/usuario/editar',[AdminController::class,'perfil'])->name('perfil_usuario');
Route::middleware(['auth'])->group(function () {

    Route::get('/perfil', [AdminController::class, 'show'])->name('perfil');
});

//Editar usuario
Route::get('/administrador/editar/{id}', [AdminController::class, 'editar_id'])->name('usuarios.editar');
Route::put('/administrador/actualizar/{id}', [AdminController::class, 'actualizar']);

Route::get('/notificaciones', [AdminController::class, 'index'])->name('notificaciones');
Route::get('/solicitudes', [AdminController::class, 'index'])->name('solicitudes');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




//Editar mascota
//Route::get('/mascotas/{id}/editar', [MascotasController::class, 'editar'])->name('editar.mascota');
Route::get('/mascotas/editar/{id}',[MascotasController::class, 'editar_id'])->name('mascotas.editar');
Route::put('mascotas/actualizar/{id}',[MascotasController::class,'actualizar']);
// Eliminar una mascota
//Route::delete('/mascotas/{id}', [MascotasController::class, 'eliminar'])->name('eliminar.mascota');
//Route::get('/masctoas/mostar/{id}',[MascotasController::class, 'mostrar_id'])->name('mostrar.mascota');
Route::delete('mascotas/borrar/{id}',[MascotasController::class,'borrar'])->name('eliminar.mascota');


//parte administrativa
 

//Usuarios
Route::view('/usuarios', '/administrador/usuarios/usuarios')->name('usuarios');
Route::view('/usuarios/registro', '/administrador/usuarios/registro')->name('registro_usuarios');
Route::get('/usuarios/listado',[UsuariosController::class,'listado'])->name('listado_usuarios');

Route::post('/usuarios/nuevo',[UsuariosController::class,'crear']);
//Editar usuario
Route::get('/usuario/editar/{id}',[UsuariosController::class, 'editar_id'])->name('usuarios.editar');
Route::put('usuarios/actualizar/{id}',[UsuariosController::class,'actualizar']);
// Eliminar un usuario
Route::delete('/usuarios/borrar/{id}', [UsuariosController::class, 'borrar'])->name('eliminar.usuario');
//Solicitudes

 

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Muestra el formulario de login
Route::post('/login', [AuthController::class, 'login']);  // Maneja la autenticación del usuario

// Ruta para el inicio de usuarios
Route::get('/usuarios/inicio', function () {
    return view('usuarios.inicio'); // Página de inicio del usuario
})->name('usuarios.inicio');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  // Cierra la sesión del usuario


// SignUp (Registro de Usuario)
Route::get('/register', [AuthController::class, 'showSignupForm'])->name('register');  // Muestra el formulario de registro
Route::post('/register', [AuthController::class, 'signup']);  // Maneja la creación de un nuevo usuario


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
