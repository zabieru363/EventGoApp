<?php
session_start();
require_once("../config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

$login_info = [
    "message" => "",
    "login" => false,
    "image" => ""
];

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $remember_me = false;

    $user = trim($_POST["username"]);
    $password = trim($_POST["pass"]);

    if(isset($_POST["remember-me"]) && $_POST["remember-me"] === "on")
    {
        $remember_me = true;
    }

    $info = $user_controller->login($user, $password, $remember_me);

    if($info["login"])
    {
        $file_name = $user_controller->setUserImage($_SESSION["id_user"]);

        $login_info["image"] = $file_name;
        $login_info["login"] = true;
    }
    else
    {
        $login_info["message"] = $info["message"];
    }

    echo json_encode($login_info);
}