<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{

    public function listado()
    {
        $usuarios = DB::table("usuarios")
            ->where("estado", "!=", "inactivo")
            ->get();
        //dd($mascotas); 
        return view("/administrador/usuarios/listado")->with('usuarios', $usuarios);
    }
    public function formulario()
    {
        return view("/usuarios/crear");
    }
    public function crear(Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'contra' => 'required|min:6',
            'telefono' => 'required|numeric',
            'direccion' => 'required|max:255',
            'imagen' => 'sometimes|file|mimes:jpg,jpeg,png|max:4096',
            'rol' => 'required|in:admin,usuario',
            'estado' => 'required|in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Recuperar datos del request
        $data = $request->all();

        // Manejo de imagen
        $imagen = $request->hasFile('imagen') ? $request->file('imagen')->store('imagenes', 'public') : null;

        // Inserción en la base de datos
        DB::table('usuarios')->insert([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'contra' => bcrypt($data['contra']), // Encriptar la contraseña
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'imagen' => $imagen,
            'rol' => $data['rol'],
            'estado' => $data['estado'],
        ]);

        return redirect('/usuarios/listado')->with('success', 'Usuario creado con éxito');
    }
    public function editar_id($id)
    {
        $usuario = DB::table('usuarios')->find($id);
        return view('/administrador/usuarios/editar')->with('usuario', $usuario);
    }
    public function actualizar($id, Request $request)
{
    // Validación
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|max:100',
        'email' => 'required|email|max:100',
        'contra' => 'required|min:6',
        'telefono' => 'required|max:15',
        'direccion' => 'nullable|max:255',
        'imagen' => 'nullable|file|mimes:jpg,jpeg,png|max:4096', // Validación para la imagen
        'rol' => 'required|in:admin,usuario',
        'estado' => 'required|in:activo,inactivo',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Excluir los campos _token y _method
    $data = $request->except('_token', '_method', 'imagen');

    // Manejo de archivos solo si hay una imagen subida
    if ($request->hasFile('imagen')) {
        $data['imagen'] = $request->file('imagen')->store('fotos', 'public');
    }

    // Actualización en la base de datos
    DB::table('usuarios')
        ->where('id', $id)
        ->update($data);

    return redirect('/usuarios/listado')->with('success', 'Usuario actualizado con éxito');
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