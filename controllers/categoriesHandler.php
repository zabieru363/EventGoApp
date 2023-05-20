<?php
require_once("../config/displayErrors.php");
require_once("CategoryController.php");
$category_controller = new CategoryController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $objects = $category_controller->listCategories();
    $categories = array_map(function($object) {
        return $object->name;
    }, $objects);

    echo json_encode($categories);
}