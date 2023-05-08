<?php
require_once("../config/displayErrors.php");
require_once("UserController.php");
$user_controller = new UserController();

function create_cities_array($cities):array
{
    $array = [
        "id" => [],
        "city" => []
    ];

    $counter = 1;

    foreach($cities as $city)
    {
        array_push($array["id"], $counter);
        array_push($array["city"], $city);
        $counter++;
    }

    return $array;
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $cities = $user_controller->getCities();
    $array = create_cities_array($cities);

    echo json_encode($array);
}