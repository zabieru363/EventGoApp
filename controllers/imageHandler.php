<?php
require_once("config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $file_name = $user_controller->setUserImage($_SESSION["id_user"]);
    echo json_encode($file_name);
}