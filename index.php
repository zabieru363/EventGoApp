<?php
    require_once("controllers/HomeController.php");
    $main_controller = new HomeController();

    $main_controller->index();
?>