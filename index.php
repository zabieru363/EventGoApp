<?php
    require_once("controllers/HomeController.php");
    require_once("lib/router.php");
    $main_controller = new HomeController();

    $main_controller->index();
?>