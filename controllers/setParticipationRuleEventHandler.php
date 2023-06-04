<?php
require_once("EventController.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    $event_id = $data->idEvent;
    $rule = $data->rule;

    $participation = [
        "rule" => 0,
        "action" => ""
    ];

    $event_controller = new EventController();
    $user_controller = new UserController();

    if($event_controller->eventParticipationRuleExists($event_id, $_SESSION["id_user"]))
    {
        $event_controller->setEventParticipationRule($event_id, $_SESSION["id_user"], $rule);
        $participation["rule"] = $rule;
        $participation["action"] = "created";
    }
    else
    {
        $event_controller->updateEventParticipationRule($event_id, $_SESSION["id_user"], $rule);
        $participation["rule"] = $rule;
        $participation["action"] = "updated";
    }

    echo json_encode($participation);
}