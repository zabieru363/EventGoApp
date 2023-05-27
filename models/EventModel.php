<?php
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");
require_once(realpath(dirname(__FILE__)) . "/../config/Connection.php");
require_once(realpath(dirname(__FILE__)) . "/entities/Event.php");

final class EventModel
{
    private static $instance;
    private Connection $connection;
    private $data = [];

    private function __construct()
    {
        $this->connection = Connection::getInstance();
        session_start();
    }

    /**
     * Método estático que activa el singleton de esta
     * clase (EventModel)
     * @return EventModel La instancia de este modelo.
     */
    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new EventModel();
        }

        return self::$instance;
    }

    /**
     * Método que inserta un evento en la tabla de eventos
     * con los valores previamente guardados en un objeto.
     * @param Event Un objeto (POJO) de tipo event.
     * @return int El id del último evento que se ha insertado.
     */
    public function addEvent(Event $event):int
    {
        $sql = "INSERT INTO event VALUES(NULL, :title, :description, :admin,
        :location, :start_date, :end_date, :active)";

        $id_event = $this->connection->execute_query_id($sql, [
            ":title" => $event->__get("title"),
            ":description" => $event->__get("description"),
            ":admin" => $event->__get("admin"),
            ":location" => $event->__get("location"),
            ":start_date" => $event->__get("start_date"),
            ":end_date" => $event->__get("end_date"),
            ":active" => $event->__get("active")
        ]);

        return $id_event;
    }

    /**
     * Método que asigna un evento a una categoria. El resultado se
     * almacena en la tabla category_event.
     * @param int El id del evento.
     * @param int El id de la categoria.
     * @return bool True si ha quedado asignado, false si no es así.
     */
    public function assignCategory(int $event_id, int $category_id):bool
    {
        $sql = "INSERT INTO category_event VALUES(:event_id, :category_id)";

        $assigned = $this->connection->execute_query($sql, [
            ":event_id" => $event_id,
            ":category_id" => $category_id
        ]);

        return $assigned;
    }

    /**
     * Método que añade una imagen a un evento. El resultado se
     * almacena en la tabla event_images.
     * @param int El id del evento.
     * @param string EL nombre del archivo que se ha subido.
     * @return bool True si se ha guardado la imagen, false si no es así.
     */
    public function addEventImage(int $event_id, string $file):bool
    {
        $sql = "INSERT INTO event_images VALUES(:event_id, :image)";

        $status = $this->connection->execute_query($sql, [
            ":event_id" => $event_id,
            ":image" => $file
        ]);

        return $status;
    }

    /**
     * Método que asocia un evento a un usuario. El resultado se guarda
     * en la tabla user_event.
     * @param int El id del evento.
     * @param int EL id del usuario.
     * @return bool Ture si el evento se ha asociado al usuario, false si no es así.
     */
    public function addEventToUserList(int $event_id, int $user_id):bool
    {
        $sql = "INSERT INTO user_event VALUES(:event_id, :user_id)";

        $status = $this->connection->execute_query($sql, [
            ":event_id" => $event_id,
            ":user_id" => $user_id
        ]);

        return $status;
    }
}