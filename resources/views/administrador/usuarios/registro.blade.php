<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin</title>

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


        <h2>Registro de Administradores</h2>
        <form action="/usuarios/nuevo" method="POST" enctype="multipart/form-data">
            @csrf

           <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Mensajes de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <label>Nombre del usuario:</label><br>
            <input name="nombre" type="text" maxlength="100" required value="{{ old('nombre') }}"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" maxlength="100" required value="{{ old('email') }}"><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="contra" required minlength="6"><br><br>

            <label>Teléfono:</label><br>
            <input type="text" name="telefono" maxlength="15" required value="{{ old('telefono') }}"><br><br>

            <label>Dirección:</label><br>
            <input type="text" name="direccion" maxlength="255" value="{{ old('direccion') }}"><br><br>

            <label>Imagen:</label><br>
            <input type="file" name="imagen" accept="image/*"><br><br>

            <label>Rol:</label><br>
            <input type="radio" name="rol" value="admin" required>
            <label>Admin</label><br><br>

            <label>Estado:</label><br>
            <input type="radio" name="estado" value="activo" required>
            <label>Activo</label>
            <input type="radio" name="estado" value="inactivo" required>
            <label>Inactivo</label><br><br>

            <input type="submit" value="Registrar Usuario">
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