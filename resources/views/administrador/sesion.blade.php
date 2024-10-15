<!DOCTYPE html>
<html>

<head>
    <title>My Awesome Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
        integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <link href="css/inicio.css" rel="stylesheet" />
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="assets/img/iniciose/image.png" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <input type="text" name="nombre" placeholder="Nombre" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Contraseña" required>
                        <button type="submit">Registrarse</button>
                    </form>


                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        Don't have an account? <a href="#" class="ml-2">Sign Up</a>
                    </div>
                    <div class="d-flex justify-content-center links">
                        <a href="#">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Añade la función para redirigir cuando se hace clic en el botón de login
        document.getElementById("loginButton").onclick = function () {
            // Aquí puedes validar el inicio de sesión antes de redirigir
            // Si es exitoso, redirigir
            window.location.href = "admin";
        };
    </script>
</body>

</html>