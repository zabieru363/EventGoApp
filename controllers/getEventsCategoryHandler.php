<?php
require_once("EventController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $event_controller = new EventController();
    $events = $event_controller->getEventsCategory($data->id);

    header("Content-Type: application/json");
    echo json_encode($events);
}