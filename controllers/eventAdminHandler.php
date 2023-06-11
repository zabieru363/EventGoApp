<?php
require_once("EventController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $event_controller = new EventController();
    $data = json_decode(file_get_contents('php://input'), true);

    $selected_ids = $data["events_selected"];
    $action = $data["action"];

    if($action === "delete")
    {
        foreach($selected_ids as $id) $event_controller->deleteEvent($id);
        echo json_encode([
            "removed" => true,
            "message" => "Eventos eliminados correctamente"
        ]);
    }

    if($action === "ban")
    {
        foreach($selected_ids as $id) $event_controller->banEvent($id);
        echo json_encode([
            "banned" => true,
            "message" => "Eventos desactivados correctamente"
        ]);
    }

    if($action === "active")
    {
        foreach($selected_ids as $id) $event_controller->activeEvent($id);
        echo json_encode([
            "activated" => true,
            "message" => "Eventos activados correctamente"
        ]);
    }
}