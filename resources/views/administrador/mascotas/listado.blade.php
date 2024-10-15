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

    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">

    @include('partials.nav_admin')


    <header class="masthead bg-primary text-white text-center">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Listado de Mascotas
                Ingresadas</h2>

            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-paw"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Foto1</th>
                                <th>Foto2</th>
                                <th>Foto3</th>
                                <th>Descripcion</th>
                                <th>Estado de salud</th>
                                <th>Estado de adopcion</th>
                                <th>Especie</th>
                                <th>Tamaño</th>
                                <th>Fecha de Ingreso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mascotas as $masc)
                                <tr>
                                    <td>{{$masc->id}}</td>
                                    <td>{{$masc->nombre}}</td>
                                    <td>{{$masc->edad}}</td>
                                    <td>
                                        @if($masc->foto1)
                                            <img src="{{ asset('storage/' . $masc->foto1) }}" alt="Foto de {{ $masc->nombre }}"
                                                width="100">
                                        @else
                                            Sin imagen
                                        @endif
                                    </td>
                                    <td>
                                        @if($masc->foto2)
                                            <img src="{{ asset('storage/' . $masc->foto2) }}" alt="Foto de {{ $masc->nombre }}"
                                                width="100">
                                        @else
                                            Sin imagen
                                        @endif
                                    </td>
                                    <td>
                                        @if($masc->foto3)
                                            <img src="{{ asset('storage/' . $masc->foto3) }}" alt="Foto de {{ $masc->nombre }}"
                                                width="100">
                                        @else
                                            Sin imagen
                                        @endif
                                    </td>
                                   
                                    <td>{{$masc->descripcion}}</td>
                                    <td>{{$masc->estado_salud}}</td>
                                    <td>{{$masc->estado_adopcion}}</td>
                                    <td>{{$masc->especie}}</td>
                                    <td>{{$masc->tamano}}</td>
                                    <td>{{$masc->fecha_ingreso}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Acciones">
                                            <a href="{{ route('mascotas.editar', ['id' => $masc->id]) }}"
                                                class="btn btn-primary btn-sm">Editar</a>

                                            <form action="{{ route('eliminar.mascota', ['id' => $masc->id]) }}"
                                                method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>

                                            <script>
                                                function confirmDelete() {
                                                    return confirm('¿Estás seguro de que deseas eliminar esta mascota?');
                                                }
                                            </script>

                                        </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </header>


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


    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Adoptame CUT 2024</small></div>
    </div>

    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" aria-labelledby="portfolioModal1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Nuestro centro</h2>

                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>

                                <img class="img-fluid rounded mb-5" src="assets/img/portfolio/cutonala1.png"
                                    alt="..." />

                                <p class="mb-4">eccnerknlcndlfknrlneoototiot fieiceirvinrinei.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Cerrar ventana
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" aria-labelledby="portfolioModal2"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Nosotros</h2>

                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>

                                <img class="img-fluid rounded mb-5" src="assets/img/portfolio/cutonala3.jpeg"
                                    alt="..." />

                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque
                                    assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam
                                    velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.
                                </p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Cerrar ventana
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 3-->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" aria-labelledby="portfolioModal3"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">desde...</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid rounded mb-5" src="assets/img/portfolio/cutonala2.jpeg"
                                    alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque
                                    assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam
                                    velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.
                                </p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Cerra ventana
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/scripts.js"></script>

    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>