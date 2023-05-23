<?php
require_once("CategoryController.php");
require_once("UserController.php");

final class HomeController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = UserModel::getInstance();
        session_start();
    }

    /**
     * Método que crea la vista principal con las
     * categorias y los eventos.
     */
    public function index():void
    {
        try{
            $category_controller = new CategoryController();
            $user_controller = new UserController();
            $categoires = $category_controller->listCategories();
            $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);

            $data = ["categories" => $categoires];
            $data = ["user_data" => $user_data];
            $this->render("home/home", $data);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}