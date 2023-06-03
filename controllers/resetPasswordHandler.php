<?php
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["pass-confirmed"]);

    $user_controller = new UserController();
    $new_password = password_hash($password, PASSWORD_BCRYPT);

    $user_info = $user_controller->emailExists($email);

    if(!$user_info["exists"])
    {
        echo json_encode([
            "process" => false,
            "message" => "Esta dirección de correo no existe."
        ]);
    }
    else
    {
        $status = $user_controller->resetUserPassword($email, $new_password);
        echo json_encode([
            "process" => $status,
            "message" => "Contraseña reestablecida. Ya puedes iniciar sesión con tu nueva contraseña."
        ]);
    }
}