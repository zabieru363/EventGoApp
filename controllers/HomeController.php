<?php
require_once("../lib/BaseController.php");
require_once("CategoryController.php");

final class HomeController extends BaseController
{
    /**
     * Método que crea la vista principal con las
     * categorias y los eventos.
     */
    public function index():void
    {
        try{
            $category_controller = new CategoryController();
            $categoires = $category_controller->listCategories();

            $data = ["categories" => $categoires];
            $this->render("home/home", $data);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}