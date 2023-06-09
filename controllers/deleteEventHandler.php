<?php
require_once("EventController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $event_controller = new EventController();
    $event_id = $_POST["event_id"];

    $event_controller->deleteEvent($event_id);
}