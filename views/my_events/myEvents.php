<?php
    session_start();
    $title = "Mis eventos";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>

        <div class="container-fluid shadow mt-3 p-3 w-50">
            <h1 class="display-6">Tus eventos</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        Eventos publicados
                    </div>

                    <div class="row">
                        Eventos en los que participas
                    </div>

                    <div class="row">
                        Pendientes de confirmación
                    </div>

                    <div class="row">
                        Eventos cancelados
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap y font-awesome -->
       <?php require_once("templates/cdns.php"); ?> 
    </body>
</html>