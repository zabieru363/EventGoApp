<?php
require_once("UserController.php");
require_once("CityController.php");
require_once("CategoryController.php");
require_once(realpath(dirname(__FILE__)) . "/../lib/BaseController.php");
require_once(realpath(dirname(__FILE__)) . "/../models/EventModel.php");

final class EventController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = EventModel::getInstance();
    }

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
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function list()
    {
        $user_controller = new UserController();
        $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
        
        $this->render("my_events/myEvents", ["user_image" => $user_image]);
    }

    /**
     * Método que llama al modelo para mandar a crear un
     * evento, devuelve el id del evento recién insertado.
     * @param Event Un objeto evento con todos los valores ya asignados.
     * @return int El id del evento recien insertado.
     */
    public function createEvent(Event $event):int
    {
        return $this->model->addEvent($event);
    }

    /**
     * Método que llama al modelo para asignar un evento a una
     * categoría.
     * @param int El id del evento.
     * @param int El id de la categoría.
     * @return bool True si la consulta ha tenido exito, false si no es así.
     */
    public function assignCategory(int $event_id, int $category_id):bool
    {
        return $this->model->assignCategory($event_id, $category_id);
    }

    /**
     * Método que llama al modelo para añadir imagenes al evento.
     * @param int El id del evento.
     * @param string EL nombre del archivo que se ha subido.
     * @return bool True si la consulta ha tenido exito, false si no es así.
     */
    public function setEventImages(int $event_id, string $file):bool
    {
        return $this->model->addEventImage($event_id, $file);
    }

    /**
     * Método que llama al modelo para asociar un evento a un usuario.
     * @param int El id del evento.
     * @param int EL id del usuario.
     * @return bool True si la consulta ha tenido exito, false si no es así.
     */
    public function addEventToUserList(int $event_id, int $user_id):bool
    {
        return $this->model->addEventToUserList($event_id, $user_id);
    }

    /**
     * Método que llama al modelo para recuperar los eventos de
     * una ctaegoría en especifico.
     */
    public function getEventsCategory(int $category_id):array
    {
        return $this->model->getEventsCategory($category_id);
    }
}