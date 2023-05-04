<?php
require_once("../config/displayErrors.php");
require_once("UserController.php");
require_once("../lib/geoplugin.class.php");
$user_controller = new UserController();

$register_status = [
    "username_message" => "",
    "email_message" => "",
    "username_exists" => false,
    "email_exists" => false
];

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $file_name = "default.png";

    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
        $file_name = $_FILES["image"]["name"];
    }

    // Instanciamos la clase GeoPlugin
    $geo = new geoPlugin();
    $geo->locate($_SERVER["REMOTE_ADDR"]);

    $country = $geo->countryName;
    $country = $geo->city;

    $info = $user_controller->createUser([
        "username" => trim($_POST["username"]),
        "password" => trim($_POST["pass"]),
        "type" => "Normal",
        "fullname" => trim($_POST["fullname"]),
        "email" => trim($_POST["email"]),
        "country" => $country,
        "city" => $city,
        "active" => 1,
        "image" => $file_name
    ]);

    if(!($info["created"]))
    {
        if($info["username_info_message"] !== "")
        {
            $register_status["username_message"] = $info["username_info_message"];
            $register_status["username_exists"] = true;
        }

        if($info["email_info_message"] !== "")
        {
            $register_status["email_message"] = $info["email_info_message"];;
            $register_status["email_exists"] = true;
        }
    }

    echo json_encode($register_status);
}