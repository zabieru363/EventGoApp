<?php
    session_start();
    $title = "Inicio";
    $css = "public/css/styles.css";
    require_once("templates/open.php");
?>
    <body>
        <header class="d-flex justify-content-between align-items-center p-2 border mb-5">
            <div class="content_header">
                <a class="anchor text-black" href="#"><h1>Logo aquí</h1></a>
            </div>

            <div class="search_events w-50">
                <!-- <span class="fa-solid fa-magnifying-glass"></span> -->
                <input class="w-100 p-2" 
                type="search" id="event_input"
                name="event_input" placeholder="Buscar eventos">
            </div>

            <?php if(isset($_SESSION["id_user"])): ?>
                <div class="auth_user_container d-flex justify-content-between">
                    <div><?php echo $_SESSION["username"] ?></div>
                    <div class="user_auth_container">
                        <div class="user-auth-circle"></div>
                        <img id="image" src="" alt="">
                        <div class="dropdown">
                            <a class="btn border user-options dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>

                            <ul class="dropdown-menu p-3">
                                <li><a class="anchor user-auth-anchor" href="#"><i class="fa-solid fa-user"></i> Mi perfil</a></li>
                                <li><a class="anchor user-auth-anchor" href="#"><i class="fa-solid fa-gear"></i> Configuración</a></li>
                                <li><a class="anchor user-auth-anchor" href="#"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="user_control">
                    <a class="text-white rounded-4 p-2" href="views/login/loginForm.php">Iniciar sesión</a>
                    <a class="text-white rounded-4 p-2 " href="views/register/registerForm.php">Registrarse</a>
                </div>
            <?php endif; ?>

        </header>

        <section class="wrapper">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
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
                </div>

                <div class="col-lg-4">
                    Filtrar por
                </div>
            </div>
        </section>

        <!-- Bootstrap y Font Awesome -->
        <?php
            require_once("./templates/cdns.php");
        ?>
    </body>
</html>