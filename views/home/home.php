<?php
    session_start();
    $title = "Inicio";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/header.php"); ?>
        <?php require_once("templates/eventsZone.php"); ?>

        <!-- JavaScript -->
        <?php if(isset($_SESSION["id_user"])): ?>
            <script src="public/js/getEventsCategoryUser.js" type="module"></script>
        <?php else: ?>
            <script src="public/js/getEventsCategory.js" type="module"></script>
        <?php endif; ?>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>