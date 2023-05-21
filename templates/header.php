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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <div class="user_control d-flex justify-content-center">
                        <?php if (!(isset($_SESSION["id_user"]))) : ?>
                            <a href="views/login/loginForm.php?view=login">Iniciar sesión</a>
                            <a href="views/register/registerForm.php?view=register">Registrarse</a>
                        <?php else : ?>
                            <div class="d-flex justify-content-center align-items-center authenticated-user-container">
                                <div class="user-image">
                                    <img src="" alt="Imagen de usuario">
                                </div>
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle user-options-dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php echo $_SESSION["username"] ?>
                                        </a>
                                        <ul class="dropdown-menu user-options">
                                            <li><a class="dropdown-item" href="views/user_profile/profile.php"><i class="fa-solid fa-user"></i> Mi perfil</a></li>
                                            <li><a class="dropdown-item" href="views/user_events/events.php"><i class="fa-solid fa-calendar"></i> Mis eventos</a></li>
                                            <li><a class="dropdown-item" href="controllers/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="create-event-container">
                                    <a href="#"><i class="fa-regular fa-plus"></i> Crear evento público</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>