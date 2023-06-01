<?php
require_once("EventController.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $event_controller = new EventController();
    $user_controller = new UserController();
    $events = $event_controller->getAllEventsy($_SESSION["id_user"]);

    echo json_encode($events);
}