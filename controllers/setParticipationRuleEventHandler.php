<?php
require_once("EventController.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    $event_id = $data->idEvent;
    $rule = $data->rule;

    $event_controller = new EventController();
    $user_controller = new UserController();

    $created = $event_controller->setEventParticipationRule($event_id, $_SESSION["id_user"], $rule);
    $result = [
        "created" => false,
        "message" => ""
    ];

    if($rule === 2)
    {
        $result["created"] = true;
        $result["message"] = "Participarás en este evento";
    }

    if($rule === 3)
    {
        $result["created"] = true;
        $result["message"] = "No participarás en este evento";
    }

    if($rule === 4)
    {
        $result["created"] = true;
        $result["message"] = "Se ha establecido en pendiente de confirmación";
    }

    echo json_encode($result);
}