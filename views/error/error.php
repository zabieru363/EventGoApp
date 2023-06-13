<?php
    $title = "Error 404";
    require_once("templates/open.php");
?>
    <body>

    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1>Error 404</h1>
            <p>Página no encontrada</p>
        </div>
        <div class="text-center">
            <a href="index.php" class="submit-btn">Volver a inicio</a>
        </div>
    </div>

        <!-- Bootstrap y FontAwesome -->
       <?php require_once("templates/cdns.php"); ?> 
    </body>
</html>