<?php
require_once("EventController.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $event_controller = new EventController();
    $user_controller = new UserController();

    if(isset($_SESSION["id_user"]))
    {
        $events = $event_controller->getAllEvents($_SESSION["id_user"]);
        echo json_encode($events);
    }
    else
    {
        $events = $event_controller->getAllEvents();
        echo json_encode($events);
    }

}