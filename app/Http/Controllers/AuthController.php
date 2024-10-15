<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Manejar la autenticación
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]); 

        // Recuperar el usuario por el email
        $user = DB::table('usuarios')->where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->contra)) {
            // Verificar el estado del usuario
            if ($user->estado != 'activo') {
                return back()->withErrors(['email' => 'Tu cuenta está inactiva.']);
            }

            // Autenticar manualmente al usuario
            Auth::loginUsingId($user->id);

            // Almacenar datos del usuario en la sesión
            session([
                'userId' => $user->id,
                'userName' => $user->nombre,
                'userEmail' => $user->email,
                'userPassword' => $user->contra,
                'userPhone' => $user->telefono,
                'userAddress' => $user->direccion,
                'userImage' => $user->imagen,

            ]);

            // Redirigir según el rol del usuario
            switch ($user->rol) {
                case 'admin':
                    return redirect()->intended('/admin')->with('userId', $user->id); // Redirigir al dashboard del administrador
                case 'usuario':
                    // Mantener al usuario en la misma página pero mostrar un mensaje de error
                    return back()->with('error', 'No tienes acceso a la parte administrativa.');
                default:
                    return redirect()->intended('/login')->with('userId', $user->id); // Redirigir a un dashboard por defecto
            }

        }

        // Si falla la autenticación, regresar con un mensaje de error
        return back()->withErrors(['email' => 'Correo o contra incorrectas']);
    }


    // Mostrar formulario de registro
    public function showSignupForm()
    {
        return view('auth.register');
    }

    // Manejar la creación de un nuevo usuario
    public function signup(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed', // Confirmación de contraseña
        ]);

        try {
            // Iniciar una transacción de base de datos
            DB::beginTransaction();

            // Crear un nuevo usuario en la base de datos
            DB::table('usuarios')->insert([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'contra' => Hash::make($request->password), // Encriptar la contraseña
                'estado' => 'activo',  // Estado por defecto
                'rol' => 'usuario',  // Rol por defecto
            ]);

            // Obtener el usuario recién creado
            $user = DB::table('usuarios')->where('email', $request->email)->first();

            // Autenticar al usuario después del registro
            Auth::loginUsingId($user->id);

            // Confirmar la transacción
            DB::commit();

            // Redirigir al dashboard o página principal
            return redirect()->route('usuario.inicio');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            // Redirigir con mensaje de error
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error durante el registro. Por favor, inténtelo de nuevo.']);
        }
    }

    // Método para cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome')->with('success', 'Sesión cerrada con éxito');
    }

}
