<?php
    $title = "Usuario desactivado";
    require_once("templates/open.php");
?>
    <body>
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1>Cuenta suspendida</h1>
            <p>Tu cuenta de usuario ha sido suspendida por malos comportamientos.</p>
        </div>
        <div class="text-center">
            <a href="index.php" class="submit-btn">Volver a inicio</a>
        </div>
    </div>
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>