<?php
require_once("UserController.php");
require_once("CityController.php");

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

            if(isset($_SESSION["id_user"]))
            {
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $this->render("create_event/create_event", [
                    "user_image" => $user_image
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