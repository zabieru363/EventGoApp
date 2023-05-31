<?php
require_once("EventController.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    $event_id = $data->idEvent;

    $event_controller = new EventController();
    $user_controller = new UserController();

    $rule = $event_controller->getEventParticipationRule($event_id, $_SESSION["id_user"]);
    $result = [
        "rule" => $rule,
        "message" => ""
    ];

    if($rule === 1) $result["message"] = "Evento público";
    if($rule === 2) $result["message"] = "Participarás en este evento";
    if($rule === 3) $result["message"] = "No participarás en este evento";
    if($rule === 4) $result["message"] = "Se ha establecido en pendiente de confirmación";

    echo json_encode($result);
}