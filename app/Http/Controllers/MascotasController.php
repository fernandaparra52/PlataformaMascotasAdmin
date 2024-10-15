<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MascotasController extends Controller
{

    public function listado()
    {
        $mascotas = DB::table("mascotas")
            ->where("estado_adopcion", "!=", "inactivo")
            ->get();
        //dd($mascotas); 
        return view("/administrador/mascotas/listado")->with('mascotas', $mascotas);
    }
    public function formulario()
    {
        return view("/mascotas/crear");
    }
    public function crear(Request $request)
    { 
        DB::beginTransaction(); // Iniciar transacción
        try {
            // Validación de los archivos y otros campos
            $validatedData = $request->validate([
                'nombre' => 'required|max:100',
                'edad' => 'required|integer|min:0',
                'sexo' => 'required|in:macho,hembra',
                'especie' => 'required|in:perro,gato',
                'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 MB
                'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 MB
                'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 MB
                'tamano' => 'required|in:Pequeño,Mediano,Grande',
                'estado_salud' => 'required|in:Bueno,Malo,Crítico',
                'estado_adopcion' => 'required|in:disponible,adoptado',
                'descripcion' => 'required|string|max:1000',
            ]);

            // Guardar las imágenes en el almacenamiento
            $fotos = []; // Inicializa el array para las fotos
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile("foto$i")) {
                    $fotos["foto$i"] = $request->file("foto$i")->store('fotos_mascotas', 'public'); // Guardar la imagen y obtener la ruta
                }
            }

            // Guardar en la base de datos
            DB::table('mascotas')->insert([
                'nombre' => $request->input('nombre'),
                'sexo' => $request->input('sexo'),
                'edad' => $request->input('edad'),
                'foto1' => $fotos['foto1'] ?? null, // Usa la ruta o null si no se subió
                'foto2' => $fotos['foto2'] ?? null,
                'foto3' => $fotos['foto3'] ?? null,
                'descripcion' => $request->input('descripcion'),
                'estado_salud' => $request->input('estado_salud'),
                'especie' => $request->input('especie'),
                'tamano' => $request->input('tamano'),
                'estado_adopcion' => $request->input('estado_adopcion')
            ]);

            DB::commit(); // Confirmar la transacción
            return redirect('/mascotas/listado')->with('success', 'Mascota registrada con éxito.');

        } catch (ValidationException $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de cualquier otro error
            return redirect()->back()->with('error', 'Ocurrió un error al intentar registrar la mascota.')->withInput();
        }
    }



    public function editar_id($id)
    {
        $mascota = DB::table('mascotas')->find($id);
        return view('/administrador/mascotas/editar')->with('mascota', $mascota);
    }


    public function actualizar($id, Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|in:Macho,Hembra',
            'especie' => 'required|in:perro,gato',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 MB
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 MB
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 MB
            'tamano' => 'required|in:Pequeño,Mediano,Grande',
            'estado_salud' => 'required|in:Bueno,Malo,Crítico',
            'estado_adopcion' => 'required|in:Disponible,Adoptado',
            'descripcion' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Recuperar los datos actuales de la mascota
        $mascota = DB::table('mascotas')->where('id', $id)->first();

        // Guardar las imágenes en el almacenamiento
        $fotos = []; // Inicializa el array para las fotos
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("foto$i")) {
                $fotos["foto$i"] = $request->file("foto$i")->store('fotos_mascotas', 'public');
            }
        }

        // Solo actualizar las fotos si están presentes, de lo contrario mantener las existentes
        $updateData = [
            'nombre' => $request->input('nombre'),
            'sexo' => $request->input('sexo'),
            'edad' => $request->input('edad'),
            'descripcion' => $request->input('descripcion'),
            'estado_salud' => $request->input('estado_salud'),
            'especie' => $request->input('especie'),
            'tamano' => $request->input('tamano'),
            'estado_adopcion' => $request->input('estado_adopcion'),
            'foto1' => isset($fotos['foto1']) ? $fotos['foto1'] : $mascota->foto1, // Mantener la existente si no se sube nueva
            'foto2' => isset($fotos['foto2']) ? $fotos['foto2'] : $mascota->foto2,
            'foto3' => isset($fotos['foto3']) ? $fotos['foto3'] : $mascota->foto3,
        ];

        // Actualización en la base de datos
        DB::table('mascotas')
            ->where('id', $id)
            ->update($updateData);

        return redirect('/mascotas/listado')->with('success', 'Mascota actualizada con éxito');
    }


    public function borrar($id)
    {
        DB::table("mascotas")
            ->where("id", "=", $id)
            ->update([
                "estado_adopcion" => "Inactivo"
            ]);
        return redirect('/mascotas/listado');
    }


}
