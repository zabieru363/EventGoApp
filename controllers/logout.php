<?php
session_start();
unset($_SESSION["id_user"]);
unset($_SESSION["username"]);

if(isset($_COOKIE["remember_me"]))
{
    setcookie("remember_me", "", time() - 3600);
}

session_destroy();

// Finalmente se redirecciona al index.php
header('Refresh: 2; url=../index.php');