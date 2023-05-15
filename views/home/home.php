<?php
    session_start();
    $title = "Inicio";
    $css = "public/css/styles.css";
    require_once("templates/open.php");
?>
    <body>
        <!-- NAVBAR -->
        <header>
            <nav class="navbar navbar-expand-lg bg-light border">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="img/logo.png" width="45" height="40">
                    </a>
                    <div class="search-events ms-5 w-50">
                        <input type="search" class="form-control border-2 event-input" placeholder="Buscar eventos">
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav ms-auto">
                            <div class="user_control d-flex justify-content-center">
                                <a href="views/login/loginForm.php">Iniciar sesión</a>
                                <a href="views/register/registerForm.php">Registrarse</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- MAIN -->
        <main>
            <div class="container fluid my-5">
                <div class="row">

                    <div class="col-md-2 categories-container">
                        <h2>Categorías</h2>
                    </div>

                    <div class="col-md-10">
                    <div class="card">
                        <h1 class="card-header display-6 p-3 text-center">Titulo del evento</h1>
                        <div class="card-body">
                            <div id="carouselControls" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="public/img/images.jpg" class="d-block w-100" alt="Imagen del evento">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="public/img/images.jpg" class="d-block w-100" alt="Imagen del evento">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="public/img/images.jpg" class="d-block w-100" alt="Imagen del evento">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                            <h5 class="card-title">Organizado por <a class="anchor" href="#">[nombre de usuario]</a></h5>
                            <div class="card-text">
                                <p class="event-description">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                    Velit aliquid eius quidem veniam dignissimos aliquam. 
                                    Reprehenderit magnam culpa qui voluptate nulla eius vero
                                    ipsum? Quam minima ullam voluptatem facere aut?
                                </p>
                                <p class="event-date">Empieza el [fecha inicio] a las [hora inicio]</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Participar
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">Puedo ir</li>
                                    <li class="dropdown-item">No puedo ir</li>
                                    <li class="dropdown-item">Todavía no lo se</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="public/js/getCategories.js"></script>
        <!-- Bootstrap y Font Awesome -->
        <?php
            require_once("./templates/cdns.php");
        ?>
    </body>
</html>