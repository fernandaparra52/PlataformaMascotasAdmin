<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth
use Illuminate\Support\Facades\Hash;



class AdminController extends Controller
{
    
    public function show() 
    {
        $usuario = Auth::user(); // Obtiene el usuario autenticado

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        return view('administrador.cuenta.perfil', compact('usuario'));
    }

    public function perfil()
    {
        $usuarios = DB::table("usuarios")
            ->where("estado", "!=", "inactivo")
            ->get();
        //dd($mascotas); 
        return view("/administrador/cuenta/perfil")->with('usuarios', $usuarios);
    }


    public function editar_id($id)
    {
        $usuario = DB::table('usuarios')->find($id);
        return view('/administrador/cuenta/editar')->with('usuario', $usuario);
    }

    public function actualizar(Request $request, $id)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'required|max:15',
            'direccion' => 'nullable|max:255',
            'imagen' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
            'contra' => 'nullable|min:6', // Cambiado a nullable
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener los datos de entrada, excluyendo el token y método
        $data = $request->except('_token', '_method', 'imagen');

        // Manejo de archivos solo si hay una imagen subida
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('fotos', 'public');
        }

        // Solo agregar la contraseña si se ingresó una nueva
        if ($request->filled('contra')) {
            $data['contra'] = Hash::make($request->contra);
        } else {
            // Si no hay nueva contraseña, no incluirla en los datos a actualizar
            unset($data['contra']);
        }

        // Actualizar los datos directamente en la base de datos
        DB::table('usuarios')
            ->where('id', $id)
            ->update($data);

        // Almacenar datos del usuario en la sesión
        session([
            'userId' => $id,
            'userName' => $request->nombre,
            'userEmail' => $request->email,
            'userPhone' => $request->telefono,
            'userPassword' => $request->contra,
            'userAddress' => $request->direccion,
            'userImage' => isset($data['imagen']) ? $data['imagen'] : session('userImage'),
        ]);

        return redirect()->back()->with('success', 'Usuario actualizado con éxito');
    }




    public function borrar($id)
    {
        DB::table("usuarios")
            ->where("id", "=", $id)
            ->update([
                "estado" => "Inactivo"
            ]);
        return redirect('/usuarios/listado');
    }

}
