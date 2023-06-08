<?php
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $user_controller = new UserController();
    $data = json_decode(file_get_contents('php://input'), true);

    $selected_ids = $data["users_selected"];
    $action = $data["action"];

    if($action === "delete")
    {
        foreach($selected_ids as $id) $user_controller->deleteUser($id);
        echo json_encode([
            "removed" => true,
            "message" => "Usuarios eliminados correctamente"
        ]);
    }

    if($action === "ban")
    {
        foreach($selected_ids as $id) $user_controller->banUser($id);
        echo json_encode([
            "banned" => true,
            "message" => "Usuarios desactivados correctamente"
        ]);
    }
}