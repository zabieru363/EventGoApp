<?php
require_once("CategoryController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $category_controller = new CategoryController();

    $data = json_decode(file_get_contents('php://input'), true);

    if($data["action"] === "delete") $category_controller->deleteCategory($data["id"]);

    if($data["action"] === "create")
    {
        $category = new Category();

        $category->__set("name", $data["name"]);

        if($category_controller->categoryExists(($category->__get("name")))) echo json_encode(["message" => "La categoría ya existe"]);
        else
        {
            $category_created = $category_controller->createCategory($category);
            echo json_encode(["id" => $category_created->__get("id"), "name" => $data["name"]]);
        } 
    }
}