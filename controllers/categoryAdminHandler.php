<?php
require_once("CategoryController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $category_controller = new CategoryController();

    $data = json_decode(file_get_contents('php://input'), true);

    if($data["action"] === "delete") $category_controller->deleteCategory($data["id"]);

    if($data["create"])
    {
        $category = new Category();

        $category->__set("name", $data["name"]);
        $id = $category_controller->createCategory($category);

        echo json_encode(["id" => $id, "name" => $data["name"]]);
    }
}