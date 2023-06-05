<?php
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["pass-confirmed"]);

    $user_controller = new UserController();

    $user_info = $user_controller->emailExists($email);
    $info = $user_controller->resetUserPassword($email, $password);

    if(!$user_info["exists"])
    {
        echo json_encode([
            "process" => false,
            "message" => "Esta dirección de correo no existe."
        ]);
    }
    else if(!($info["status"]))
    {
        echo json_encode([
            "process" => false,
            "message" => $info["message"]
        ]);
    }
    else
    {
        echo json_encode([
            "process" => true,
            "message" => $info["message"]
        ]);
    }
}