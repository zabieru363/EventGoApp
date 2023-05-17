<?php
require_once("../config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);
    echo json_encode($user_data);
}