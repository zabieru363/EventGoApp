<?php
require_once("UserController.php");
$user_controller = new UserController();

if(isset($_COOKIE["remember_me"]))
{
    setcookie("remember_me", "", time() - 3600);
    $user_controller->deleteToken($_SESSION["id_user"]);
}

unset($_SESSION["id_user"]);
unset($_SESSION["username"]);

session_destroy();

// Finalmente se redirecciona al index.php
header('Refresh: 2; url=../index.php');