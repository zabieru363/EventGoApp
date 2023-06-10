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
            $categories = $category_controller->listCategories();
            $user_controller->restoreUserSession();

            if(isset($_SESSION["id_user"]))
            {
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $user_active = $user_controller->isUserActive($_SESSION["id_user"]);
                $this->render("home/home", [
                    "user_image" => $user_image,
                    "categories" => $categories,
                    "user_active" => $user_active
                ]);
            }
            else
            {
                $data = ["categories" => $categories];
                $this->render("home/home", $data);
            }
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}