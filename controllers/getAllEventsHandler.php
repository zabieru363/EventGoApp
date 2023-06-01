<?php
require_once("EventController.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $event_controller = new EventController();
    $user_controller = new UserController();
    $events = $event_controller->getAllEventsy($_SESSION["id_user"]);

    header("Content-Type: application/json");
    echo json_encode($events);
}