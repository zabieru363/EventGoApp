<?php
require_once("../config/displayErrors.php");
require_once("CategoryController.php");
$category_controller = new CategoryController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $objects = $category_controller->listCategories();

    $categories = [];

    foreach($objects as $object)
    {
        array_push($categories, $object->name);
    }

    echo json_encode($categories);
}