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
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="css/mascotas.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
       
        @include('partials.nav_admin')
       
       
        <header class="masthead bg-primary text-white text-center">
           
                <div>
                    <ul class="navbar-nav ms-auto">
                        
                      
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('registro_usuarios')}}">Registro</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('listado_usuarios')}}">Listado</a></li>
                      
                        
                    </ul>
 
                </div>
    
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
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                    
                    </div>
                   
                    
                </div>
            </div>
        </footer>
       
        
       
     
       
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      
        <script src="js/scripts.js"></script>
       
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>

