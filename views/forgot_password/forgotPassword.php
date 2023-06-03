<?php
    $title = "COntraseña olvidada";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>

        <section class="wrapper d-flex justify-content-center">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="p-5 shadow">
                        <h1 class="display-5 mb-3">Reestablecer contraseña</h1>
                        <form name="login-form" id="login-form" method="POST" action="#">
                            <div class="mb-3">
                                <label for="username" class="form-label">Introduce tu dirección de correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="pass" name="pass">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="pass-confirmed" name="pass-confirmed">
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <button type="submit" name="login" class="submit-btn">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- JavaScript -->
        <script src="public/js/validateResetPasswordForm.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>