<?php
require_once("../config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $cities = [];
    
    $cities = $user_controller->getCities();

    echo json_encode($array);
}