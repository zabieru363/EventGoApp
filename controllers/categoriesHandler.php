<?php
require_once("../config/displayErrors.php");
require_once("CategoryController.php");
$category_controller = new CategoryController();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $categories = $category_controller->listCategories();
    json_encode($categories);
}