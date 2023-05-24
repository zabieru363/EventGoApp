<?php
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $user_controller = new UserController();

    $file_name = "";
    $tmp = "";

    $user_updated = [
        "Password_hash" => "",
        "Name" => "",
        "City" => 0,
        "Image" => ""
    ];

    if(!(empty($_POST["pass"])))
    {
        $password_hash = password_hash(trim($_POST["pass"]), PASSWORD_BCRYPT);
        $user_updated["Password_hash"] = $password_hash;
    }

    if(!(empty($_POST["fullname"]))) $user_updated["Name"] = trim($_POST["fullname"]);
    if(!(empty($_POST["cities"]))) $user_updated["City"] = $_POST["cities"];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
        $file_name = $_FILES["image"]["name"];
        $user_updated["Image"] = $file_name;
        $tmp = $_FILES["image"]["tmp_name"];
    }

    if($file_name !== "")
    {
        if(!(file_exists("uploads/" . $file_name)))
        {
            $route = "uploads/" . $file_name;
            move_uploaded_file($tmp, $route);
        }
    }

    $updated_fields = $user_controller->updateUser($_SESSION["id_user"], $user_updated);
    $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);
    $updated_fields["City"] = $user_data["city"];

    echo json_encode($updated_fields);
}