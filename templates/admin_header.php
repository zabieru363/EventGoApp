<!-- NAVBAR -->
<header>
    <nav class="navbar navbar-expand-lg bg-light border">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="public/img/logo.png" width="60" height="40">
            </a>
            <h1 class="display-6">Administrador</h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <div class="user_control d-flex justify-content-center">
                        <?php if ((isset($_SESSION["id_user"]))) : ?>
                            <div class="d-flex justify-content-center align-items-center authenticated-user-container">
                                <div class="user-image">
                                    <img src="<?php echo "uploads/" . $user_image ?>" alt="Imagen de usuario">
                                </div>
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle user-options-dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php echo $_SESSION["username"] ?>
                                        </a>
                                        <ul class="dropdown-menu user-options">
                                            <li><a class="dropdown-item" href="index.php?url=logout"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>