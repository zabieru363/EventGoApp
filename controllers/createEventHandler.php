<?php
require_once("EventController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $event_controller = new EventController();
    
    // Recibiendo los campos:
    $event_title = trim($_POST["event_title"]);
    $event_description = trim($_POST["event_description"]);

    $radio = "";
    $admin_name = "";

    if(isset($_POST["adminRadio"])) $radio = $_POST["adminRadio"];

    if($radio === "me")
    {
        $admin_name = $_SESSION["username"];
    }
    else
    {
        $admin_name = trim($_POST["administrator_name"]);
    }

    $location = $_POST["locations"];
    $category = $_POST["event_categories"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    $event = new Event();

    $event->__set("title", $event_title);
    $event->__set("description", $event_description);
    $event->__set("admin", $admin_name);
    $event->__set("location", $location);
    $event->__set("start_date", $start_date);
    $event->__set("end_date", $end_date);
    $event->__set("active", 1);

    $event_id = $event_controller->createEvent($event);
    $created = $event_id <= 0 || is_null($event_id) ? false : true; 
    $assigned = $event_controller->assignCategory($event_id, $category);
    $user_event_assoc = $event_controller->addEventToUserList($event_id, $_SESSION["id_user"]);

    $files = [];

    if(isset($_FILES["images"]) && $_FILES["images"]['error'] == UPLOAD_ERR_OK)
    {
        for($i = 0; $i < count($_FILES["images"]); $i++)
        {
            $files[$i]["name"] = $_FILES["images"]["name"][$i];
            $files[$i]["tmp"] = $_FILES["images"]["tmp"][$i];

            if(!(file_exists("uploads/" . $files[$i]["name"])))
            {
                move_uploaded_file($files[$i]["tmp"], realpath(dirname(__FILE__)) . "/../uploads/" . $files[$i]["name"]);
            }

            $image_event_assoc = $event_controller->setEventImages($event_id, $files[$i]["name"]);
        }
    }

    echo json_encode([
        "created" => $created,
        "assigned" => $assigned,
        "event_user_assoc" => $user_event_assoc,
        "images_ok" => $image_event_assoc
    ]);
}