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
    $user = new User();

    $file_name = "default.png";

    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
        $file_name = $_FILES["image"]["name"];
        $tmp = $_FILES["image"]["tmp_name"];
    }

    $geo = new geoPlugin();
    $geo->locate($_SERVER["REMOTE_ADDR"]);

    $country = $geo->countryName;
    $city = $geo->city;

    if(is_null($country))
    {
        $country = "default";
    }

    if(is_null($city))
    {
        $city = "default";
    }

    $user->__set("username", trim($_POST["username"]));
    $user->__set("password", trim($_POST["pass"]));
    $user->__set("type", "Normal");
    $user->__set("fullname", trim($_POST["fullname"]));
    $user->__set("email", trim($_POST["email"]));
    $user->__set("country", $country);
    $user->__set("city", $city);
    $user->__set("active", 1);
    $user->__set("image", $file_name);

    $info = $user_controller->createUser($user);

    if(!($info["created"]))
    {
        if($file_name !== "default.png")
        {
            $route = "../uploads" . $file_name;
            move_uploaded_file($tmp, $route);
        }

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