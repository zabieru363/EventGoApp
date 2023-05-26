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
        }
    }
}