<?php
require_once("UserController.php");
require_once("CategoryController.php");
require_once("EventController.php");

final class AdminController extends BaseController
{
    public function __construct() {}

    /**
     * Método que crea una vista de administración para poder
     * administrar la tabla de usuarios.
     */
    public function users():void
    {
        $user_controller = new UserController();

        if(isset($_SESSION["id_user"]))
        {
            try {
                $users = $user_controller->listUsers();
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $this->render("backoffice/usersAdminZone", [
                    "users" => $users,
                    "user_image" => $user_image
                ]);
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php");
        }
    }

    /**
     * Método que crea una vista de administración para poder
     * administrar la tabla de eventos.
     */
    public function events():void
    {
        $event_controller = new EventController();
        $user_controller = new UserController();

        if(isset($_SESSION["id_user"]))
        {
            try {
                $page = $_GET["page"] ?? 1;
                $params = $event_controller->listEvents($page, 5);
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $this->render("backoffice/eventsAdminZone", [
                    "user_image" => $user_image,
                    "params" => $params
                ]);
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php");
        }
    }

    /**
     * Método encargado de renderizar una vista para la
     * creación de nuevas categorias.
     */
    public function categories():void
    {
        $user_controller = new UserController();
        $category_controller = new CategoryController();

        if(isset($_SESSION["id_user"]))
        {
            try{
                $categories = $category_controller->listCategoriesWithNumberOfEvents();
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $this->render("backoffice/categoriesAdminZone", [
                    "categories" => $categories,
                    "user_image" => $user_image
                ]);
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php");
        }
    }
}