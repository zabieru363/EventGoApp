<?php
    session_start();
    $title = "Inicio";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/header.php"); ?>
        <?php require_once("templates/eventsZone.php"); ?>

        <!-- JavaScript -->
        <script src="public/js/getEventsCategory.js" type="module"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>