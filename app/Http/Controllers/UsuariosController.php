<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

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
        DB::beginTransaction(); // Iniciar la transacción
        try {
            // Validación
            $validatedData = $request->validate([
                'nombre' => 'required|max:100',
                'email' => 'required|email|unique:usuarios,email',
                'contra' => 'required|min:6',
                'telefono' => 'required|numeric',
                'direccion' => 'required|max:255',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // Máximo 10MB
                'rol' => 'required|in:admin,usuario',
                'estado' => 'required|in:activo,inactivo',
            ]);

            // Procesar la imagen si está presente
            if ($request->hasFile('imagen')) {
                // Guardar la imagen en 'public/imagenes' dentro de storage/app/public
                $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
            }

            // Inserción en la base de datos
            DB::table('usuarios')->insert([
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'contra' => bcrypt($validatedData['contra']), // Encriptar la contraseña
                'telefono' => $validatedData['telefono'],
                'direccion' => $validatedData['direccion'],
                'imagen' => isset($rutaImagen) ? $rutaImagen : null, // Guardar la ruta de la imagen o null si no hay imagen
                'rol' => $validatedData['rol'],
                'estado' => $validatedData['estado'],
            ]);

            DB::commit(); // Confirmar la transacción
            return redirect('/usuarios/listado')->with('success', 'Usuario creado con éxito');

        } catch (ValidationException $e) {
            DB::rollBack(); // Revertir la transacción si hay un error de validación
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción por cualquier otro error
            return redirect()->back()->with('error', 'Ocurrió un error al intentar registrar al usuario.')->withInput();
        }
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
            'imagen' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Validación para la imagen
            'rol' => 'required|in:admin,usuario',
            'estado' => 'required|in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Recuperar datos actuales del usuario
        $usuario = DB::table('usuarios')->where('id', $id)->first();

        // Excluir los campos _token y _method
        $data = $request->except('_token', '_method', 'imagen');

        // Manejar la imagen: eliminar la anterior y almacenar la nueva si se proporciona
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($usuario->imagen) {
                \Log::info("Intentando eliminar la imagen anterior: " . $usuario->imagen);

                // Usar la ruta correcta para eliminar la imagen
                $rutaImagenAnterior = 'fotos/' . basename($usuario->imagen);
                if (Storage::disk('public')->exists($rutaImagenAnterior)) {
                    Storage::disk('public')->delete($rutaImagenAnterior);
                    \Log::info("Imagen eliminada: " . $rutaImagenAnterior);
                } else {
                    \Log::warning("No se encontró la imagen para eliminar: " . $rutaImagenAnterior);
                }
            }

            // Almacenar la nueva imagen
            $imagen = $request->file('imagen')->store('fotos', 'public');
        } else {
            // Si no hay nueva imagen, mantener la existente
            $imagen = $usuario->imagen;
        }

        // Preparar los datos para la actualización
        $updateData = [
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'contra' => bcrypt($data['contra']), // Asegúrate de encriptar la contraseña
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'rol' => $data['rol'],
            'estado' => $data['estado'],
            'imagen' => $imagen, // Aquí se asigna la nueva imagen o la existente
        ];

        // Actualización en la base de datos
        DB::table('usuarios')
            ->where('id', $id)
            ->update($updateData);

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