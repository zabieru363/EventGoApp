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
            else
            {
                header("Location: index.php?url=login");
            }
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Método que renderiza la vista de la lista de
     * eventos del usuario. Si el usuario no tiene la sesión
     * iniciada, redireccionará al login.
     */
    public function list():void
    {
        $user_controller = new UserController();
        if(isset($_SESSION["id_user"]))
        {
            try {
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $public_user_events = $this->getUserPublicEvents($_SESSION["id_user"]);
                $user_participation_events = $this->getUserEventsParticipation($_SESSION["id_user"]);
                $cancelled_events = $this->getUserCancelledEvents($_SESSION["id_user"]);
                $pending_events = $this->getUserPendingEvents($_SESSION["id_user"]);
                
                $this->render("my_events/myEvents", [
                    "user_image" => $user_image,
                    "public_user_events" => $public_user_events,
                    "user_participation_events" => $user_participation_events,
                    "cancelled_events" => $cancelled_events,
                    "pending_events" => $pending_events
                ]);
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php?url=login");
        }
    }

    /**
     * Método que renderiza una vista con los detalles de
     * un evento en base al id que recibe por la url.
     */
    public function details():void
    {
        $user_controller = new UserController();

        try {
            $event_id = $_GET["id"];

            if(isset($_SESSION["id_user"]))
            {
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $event = $this->getEventById($event_id, $_SESSION["id_user"]);
                $event_images = explode("/", $event["images"]);
                
                $this->render("home/eventDetails", [
                    "user_image" => $user_image,
                    "event" => $event,
                    "event_images" => $event_images
                ]);
            }
            else
            {
                $event = $this->getEventById($event_id, 0);
                $event_images = explode("/", $event["images"]);
                $this->render("home/eventDetails", [
                    "event" => $event,
                    "event_images" => $event_images
                ]);
            }
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
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
     * Método que llama al modelo para buscar eventos por
     * titulo de evento, mirando a ver si coincide con lo
     * que escribió el usuario.
     * @param string Lo que escribió el usuario en el input de eventos.
     * @return array Un array asociativo con el id y el titulo
     * de los eventos que encontró.
     */
    public function searchEvent(string $search):array
    {
        return $this->model->searchEvent($search);
    }

    /**
     * Método que llama al modelo para recuperar los eventos de
     * una ctaegoría en especifico.
     * @param int El id del usuario para asociar las reglas a los eventos.
     * @return array Un array con todos los eventos.
     */
    public function getAllEvents(int $user_id = null):array
    {
        return $this->model->getAllEvents($user_id);
    }

    /**
     * Método que llama al modelo para obtener los eventos
     * publicados por un usuario.
     * @param int El id del usuario del cuál se quieren
     * obtener sus eventos publicados.
     */
    public function getUserPublicEvents(int $user_id):array
    {
        return $this->model->getUserPublicEvents($user_id);
    }

    /**
     * Método que llama al modelo para recuperar los eventos
     * en los que el usuario va a participar.
     * @param int El id del usuario del cuál se quieren obtener
     * los eventos en los cuales va a participar.
     * @return array Los eventos en los que va a participar
     * ese usuario.
     */
    public function getUserEventsParticipation(int $user_id):array
    {
        return $this->model->getUserEventsParticipation($user_id);
    }

    /**
     * Método llama al modelo para recuperar los eventos en los cuáles
     * el usuario no va a participar.
     * @param int El id del usuario para recuperar los eventos en los
     * cuáles no va a participar.
     * @return array Los eventos en los cuáles no participa el usuario.
     */
    public function getUserCancelledEvents(int $user_id):array
    {
        return $this->model->getUserCancelledEvents($user_id);
    }

    /**
     * Método llama al modelo para recuperar los eventos en los cuáles
     * el usuario no sabe si va a participar o no.
     * @param int El id del usuario para recuperar los eventos en los
     * cuáles no sabe si va a participar o no.
     * @return array Los eventos en los cuáles el usuario no sabe si va a participar o no.
     */
    public function getUserPendingEvents(int $user_id):array
    {
        return $this->model->getUserPendingEvents($user_id);
    }

    /**
     * Método que llama al modelo y crea una regla de participación o
     * de estado de un evento, para un usuario.
     * @param int El id del evento del cuál se quiere cambiar la regla.
     * @param int El id de la regla que se quiere aplicar a ese evento.
     * @return bool True si la operación ha tenido exito, false si no fue así.
     */
    public function setEventParticipationRule(int $event_id, int $user_id, int $rule_id):bool
    {
        return $this->model->setEventParticipationRule($event_id, $user_id, $rule_id);
    }

    /**
     * Método que llama al modelo y cambia la regla de participación o
     * de estado de un evento.
     * @param int El id del evento del cuál se quiere cambiar la regla.
     * @param int El id de la regla que se quiere aplicar a ese evento.
     * @return bool True si la operación ha tenido exito, false si no fue así.
     */
    public function updateEventParticipationRule(int $event_id, int $user_id, int $rule_id):bool
    {
        return $this->model->updateEventParticipationRule($event_id, $user_id, $rule_id);
    }

    /**
     * Método que llama al modelo y comprueba que una regla de participación
     * de un evento existe para un usuario.
     * @param int El id del evento que se quiere comprobar.
     * @param int El id del usuario que se quiere comprobar.
     * @return bool True si existe, false si no es así.
     */
    public function eventParticipationRuleExists(int $event_id, int $user_id):bool
    {
        return $this->model->eventParticipationRuleExists($event_id, $user_id);
    }

    /**
     * Método que obtiene todos los eventos de aplicando un
     * limitador.
     * @param int El comienzo desde donde se quieren empezar a
     * obtener registros.
     * @param int El final hasta donde se quieren obtener registros.
     * @return array Un array con los eventos obtenidos y sus datos.
     */
    public function listEvents(int $page = 1, int $perPage):array
    {
        $start = ($page - 1) * $perPage;
        $end = $start + $perPage;
        $total_rows = $this->getNumberofTotalEvents();
        $total_pages = ceil($total_rows / $perPage);

        $events = $this->model->listEvents($start, $end);

        return [
            "events" => $events,
            "pagination" => [
                "total_pages" => $total_pages,
                "current_page" => $page,
                "events_per_page" => $perPage,
                "total_events" => $total_rows
            ]
        ];
    }

    /**
     * Método que llama al modelo y obtiene el número total
     * de eventos que hay en la tabla event.
     * @return int El número total de eventos que hay en la tabla event.
     */
    public function getNumberofTotalEvents():int
    {
        return $this->model->getNumberofTotalEvents();
    }

    /**
     * Método que llama al modelo para eliminar un evento
     * @param int El id del evento que se quiere eliminar.
     * @return bool True si se ha eliminado, false si no es asñi.
     */
    public function deleteEvent(int $event_id):bool
    {
        return $this->model->deleteEvent($event_id);
    }

    /**
     * Método que llama al modelo para desactivar un evento.
     * @param int El id del evento que se quiere desactivar.
     * @return bool True si se ha activado, false si no es así.
     */
    public function banEvent(int $event_id):bool
    {
        return $this->model->banEvent($event_id);
    }

    /**
     * Métood que llama al modelo para activar un evento.
     * @param int El id del evento que se quiere activar.
     * @return bool True si se ha activado, false si no es así.
     */
    public function activeEvent(int $event_id):bool
    {
        return $this->model->activeEvent($event_id);
    }

    /**
     * Método que llama al modelo para recuperar un evento por
     * id de evento y por id de usuario
     * @param int El id de usuario que realizó la búsqueda.
     * @param int El id del evento que se recuperó de la búsqueda.
     * @return array Un array asociativo con los datos del evento
     * que se recuperó en base al id.
     */
    public function getEventById(int $user_id, int $event_id):array
    {
        return $this->model->getEventById($user_id, $event_id);
    }
}