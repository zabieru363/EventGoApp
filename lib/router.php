<?php
require_once("controllers/RegisterController.php");

$view = isset($_GET["view"]) ? $_GET['view'] : "index";

switch($view)
{
    case "register" :
        $register_controller = new RegisterController();
        $register_controller->index();
        break;
}