<?php
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $user_controller = new UserController();
    $new_password = password_hash($password, PASSWORD_BCRYPT);

    if($user_controller->emailExists($email))
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