<?php
require_once("../config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

$login_info = [
    "message" => "",
    "login" => false
];

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $user = trim($_POST["user"]);
    $password = trim($_POST["pass"]);

    $info = $user_controller->login($user, $password);

    if($info["login"])
    {
        $login_info["login"] = true;
    }
    else
    {
        $login_info["message"] = $info["message"];
    }

    echo json_encode($login_info);
}