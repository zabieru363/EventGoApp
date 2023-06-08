<?php
require_once("EventController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $search = trim($_POST["search"]);

    $event_controller = new EventController();
    $results = $event_controller->searchEvent($search);

    echo json_encode($results);
}