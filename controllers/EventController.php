<?php
require_once("UserController.php");
require_once("CityController.php");
require_once("CategoryController.php");

final class EventController extends BaseController
{
    /**
     * Método que carga la vista con un formulario
     * para crear un evento.
     */
    public function create()
    {
        try{
            $user_controller = new UserController();
            $city_controller = new CityController();
            $category_controller = new CategoryController();

            if(isset($_SESSION["id_user"]))
            {
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $cities = $city_controller->listCities();
                $categories = $category_controller->listCategories();
                $this->render("create_event/create_event", [
                    "user_image" => $user_image,
                    "cities" => $cities,
                    "categories" => $categories
                ]);
            }
            else
            {
                $this->render("create_event/create_event");
            }
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }
}