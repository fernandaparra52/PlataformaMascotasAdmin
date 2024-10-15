<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Hola, Admin {{ session('userId') }}</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link href="/css/mascotas.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">

    @include('partials.nav_admin')


    <header class="masthead bg-primary text-white text-center">

        <h2>Actualizar Mascotas</h2>
        <form action="/mascotas/actualizar/{{ $mascota->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <label>Nombre de la Mascota:</label><br>
            <input name="nombre" type="text" maxlength="100" required
                value="{{ old('nombre', $mascota->nombre) }}"><br><br>

            <label>Edad (en años):</label><br>
            <input type="number" name="edad" min="0" required value="{{ old('edad', $mascota->edad) }}"><br><br>

            <label>Sexo:</label><br>
            <input type="radio" name="sexo" value="Macho" {{ old('sexo', $mascota->sexo) == 'Macho' ? 'checked' : '' }}
                required>
            <label>Macho</label>
            <input type="radio" name="sexo" value="Hembra" {{ old('sexo', $mascota->sexo) == 'Hembra' ? 'checked' : '' }}
                required>
            <label>Hembra</label><br><br>

            <label>Tipo de Mascota:</label><br>
            <select name="especie" required>
                <option value="perro" {{ old('especie', $mascota->especie) == 'perro' ? 'selected' : '' }}>Perro</option>
                <option value="gato" {{ old('especie', $mascota->especie) == 'gato' ? 'selected' : '' }}>Gato</option>
            </select><br><br>

            <label>Foto 1:</label><br>
            <input type="file" name="foto1" accept="image/*"><br><br>
            @if($mascota->foto1)
                <img src="{{ asset('storage/' . $mascota->foto1) }}" alt="Foto 1" width="200"><br>
            @endif

            <label>Foto 2:</label><br>
            <input type="file" name="foto2" accept="image/*"><br><br>
            @if($mascota->foto2)
                <img src="{{ asset('storage/' . $mascota->foto2) }}" alt="Foto 2" width="200"><br>
            @endif

            <label>Foto 3:</label><br>
            <input type="file" name="foto3" accept="image/*"><br><br>
            @if($mascota->foto3)
                <img src="{{ asset('storage/' . $mascota->foto3) }}" alt="Foto 3" width="200"><br>
            @endif

            <label>Tamaño de la mascota:</label><br>
            <select name="tamano" required>
                <option value="Pequeño" {{ old('tamano', $mascota->tamano) == 'Pequeño' ? 'selected' : '' }}>Pequeño
                </option>
                <option value="Mediano" {{ old('tamano', $mascota->tamano) == 'Mediano' ? 'selected' : '' }}>Mediano
                </option>
                <option value="Grande" {{ old('tamano', $mascota->tamano) == 'Grande' ? 'selected' : '' }}>Grande</option>
            </select><br><br>

            <label>Estado de salud:</label><br>
            <input type="radio" name="estado_salud" value="Bueno" {{ old('estado_salud', $mascota->estado_salud) == 'Bueno' ? 'checked' : '' }} required>
            <label>Bueno</label>
            <input type="radio" name="estado_salud" value="Malo" {{ old('estado_salud', $mascota->estado_salud) == 'Malo' ? 'checked' : '' }} required>
            <label>Malo</label>
            <input type="radio" name="estado_salud" value="Crítico" {{ old('estado_salud', $mascota->estado_salud) == 'Crítico' ? 'checked' : '' }} required>
            <label>Crítico</label><br><br>

            <label>Estado de adopción:</label><br>
            <input type="radio" name="estado_adopcion" value="Disponible" {{ old('estado_adopcion', $mascota->estado_adopcion) == 'Disponible' ? 'checked' : '' }} required>
            <label>Disponible</label>
            <input type="radio" name="estado_adopcion" value="Adoptado" {{ old('estado_adopcion', $mascota->estado_adopcion) == 'Adoptado' ? 'checked' : '' }} required>
            <label>Adoptado</label><br><br>

            <label for="descripcion">Descripción:</label><br>
            <textarea name="descripcion" rows="4" cols="50"
                required>{{ old('descripcion', $mascota->descripcion) }}</textarea><br><br>

            <input type="submit" value="Actualizar Mascota">
        </form>




    </header>


    </div>
    </div>
    </div>
    <div class="container">

    </div>
    </section>


    <footer class="footer text-center">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4"></h4>
                    <p class="lead mb-0">

                        <br />

                    </p>
                </div>

                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Redes Sociales</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i
                            class="fab fa-fw fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i
                            class="fab fa-fw fa-linkedin-in"></i></a>

                </div>


            </div>
        </div>
    </footer>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/scripts.js"></script>

    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>