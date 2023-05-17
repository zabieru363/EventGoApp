<?php
require_once("../config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);
    echo json_encode($user_data);
}

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $file_name = "";
    $tmp = "";

    $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);

    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
        $file_name = $_FILES["image"]["name"];
        $tmp = $_FILES["image"]["tmp_name"];
    }

    $user_data["Image"] = $file_name;

    if($user_data["Image"] !== "")
    {
        if(!(file_exists("../uploads/" . $user_data["Image"])))
        {
            $route = "../uploads/" . $user_data["Image"];
            move_uploaded_file($tmp, $route);
        }
    }
    
    $user_info = $user_controller->usernameExists($user_data["username"]);

    if($user_info["exists"])
    {
        $user_data["username"] = $user_info["message"];
    }
    else
    {
        $user_data["username"] = trim($_POST["username"]);
    }

    $email_info = $user_controller->emailExists($user_data["email"]);

    if($email_info["exists"])
    {
        $user_data["email"] = $email_info["message"];
    }
    else
    {
        $user_data["email"] = trim($_POST["email"]);
    }

    $user_data["name"] = trim($_POST["fullname"]);

    if(!($user_info["exists"]) && !($email_info["exists"]))
    {
        $updated = $user_controller->updateUser($_SESSION["id_user"], $user_data);

        if($updated)
        {
            $user_data["updated"] = true;
        }
    }

    echo json_encode($user_data);
}