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
    $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);

    $file_name = "";
    $tmp = "";

    $user_updated = [
        "username" => "",
        "name" => "",
        "email" => "",
        "image" => ""
    ];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
        $file_name = $_FILES["image"]["name"];
        $user_updated["image"] = $file_name;
        $tmp = $_FILES["image"]["tmp_name"];
    }

    if($file_name !== "")
    {
        if(!(file_exists("../uploads/" . $file_name)))
        {
            $route = "../uploads/" . $file_name;
            move_uploaded_file($tmp, $route);
        }
    }
    
    $user_info = $user_controller->usernameExists(trim($_POST["username"]));

    if($user_info["exists"])
    {
        $user_updated["username_exists"] = true;
    }
    else
    {
        $user_updated["username"] = trim($_POST["username"]);
        $user_updated["username_exists"] = false;
    }

    $email_info = $user_controller->emailExists(trim($_POST["email"]));

    if($email_info["exists"])
    {
        $user_updated["email_exists"] = true;
    }
    else
    {
        $user_updated["email"] = trim($_POST["email"]);
        $user_updated["email_exists"] = false;
    }

    $user_updated["name"] = trim($_POST["fullname"]);

    /* Si el usuario ha introducido el mismo usuario y email no
    haría falta hacer el UPDATE. */
    if($user_data["username"] !== $_POST["username"]
    || $user_data["name"] !== $_POST["fullname"]
    || $user_data["email"] !== $_POST["email"]
    || $user_data["Image"] !== $user_updated["image"])
    {
        if(!($user_info["exists"]) && !($email_info["exists"]))
        {
            $updated = $user_controller->updateUser($_SESSION["id_user"], $user_updated);
        
            if($updated)
            {
                $user_updated["updated"] = true;
            }
            
            echo json_encode($user_updated);
        }
    }
}