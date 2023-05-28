<?php
    $title = "Iniciar sesión";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>
        
        <section class="wrapper d-flex justify-content-center">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="p-5 shadow">
                        <h1 class="display-5 mb-3">Iniciar sesión</h1>
                        <form name="login-form" id="login-form" method="POST" action="#">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario o correo</label>
                                <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="pass" name="pass">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember-me" id="remember-me">
                                <label class="form-check-label" for="remember-me">Recuerdame</label>
                            </div>
                            <div class="mb-3">
                                ¿No tienes una cuenta? <a href="../register/registerForm.php">Registrate</a>
                            </div>
                            <div class="forgot-password-container mb-3">
                                <a href="#">¿Has olvidado tu contraseña?</a>
                            </div>
                            <div class="login-error d-none"></div>
                            
                            <button type="submit" name="login" class="submit-btn">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <script src="public/js/login.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>