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
            ":user_id" => $user_id,
        ]);

        return $status;
    }

    /**
     * Método que recupera todos los eventos de una categoróa y los
     * guarda en el array privado data.
     * @param int El id de la categoría por el cuál se quiere filtrar.
     * @return array Un array con todos los eventos de esa categoría.
     * Incluye también las imagenes en la última columna, separadas por el " "
     */
    public function getEventsCategory(int $category_id):array
    {
        $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
        e.Start_date, e.Ending_date, GROUP_CONCAT(ei.Image SEPARATOR '/') AS
        Image_Name FROM event e 
        INNER JOIN event_images ei ON e.Id = ei.Event_id
        INNER JOIN city c ON c.Id = e.Location
        INNER JOIN category_event ec ON ec.Event_id = e.Id
        WHERE ec.Category_id = :id_category
        GROUP BY e.Id;";

        $this->connection->execute_select($sql, [":id_category" => $category_id]);
        $this->data = [];   // Vaciamos el contenido del array para poder insertar de nuevo.

        foreach($this->connection->rows as $row)
        {
            $new_row = [];

            $new_row["id"] = $row["Id"];
            $new_row["title"] = $row["Title"];
            $new_row["description"] = $row["Description"];
            $new_row["admin"] = $row["Admin"];
            $new_row["city"] = $row["City_Name"];
            $new_row["start_date"] = $row["Start_date"];
            $new_row["end_date"] = $row["Ending_date"];
            $new_row["images"] = $row["Image_Name"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que trae con una consulta los eventos que ha publicado un
     * usuario.
     * @param int El id del usuario del cuál se quieren obtener
     * los eventos publicados.
     * @return array Un array de asociativo que contiene los eventos
     * que ha publicado el usuario con la información de cada evento.
     */
    public function getUserPublicEvents(int $user_id):array
    {
        $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
        e.Start_date, e.Ending_date FROM event e 
        INNER JOIN user_event ue ON e.Id = ue.Id_event
        INNER JOIN user u ON ue.Id_user = u.Id
        INNER JOIN city c ON c.Id = e.Location
        WHERE u.Id = :user_id;";

        $this->connection->execute_select($sql, [":user_id" => $user_id]);
        $this->data = [];   // Vaciamos el contenido del array para poder insertar de nuevo.

        foreach($this->connection->rows as $row)
        {
            $new_row = [];

            $new_row["id"] = $row["Id"];
            $new_row["title"] = $row["Title"];
            $new_row["description"] = $row["Description"];
            $new_row["admin"] = $row["Admin"];
            $new_row["city"] = $row["City_Name"];
            $new_row["start_date"] = $row["Start_date"];
            $new_row["end_date"] = $row["Ending_date"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que hace una consulta a la tabla user_event para cmabiar el
     * estado de un evento.
     * @param int El id del evento del cuál se quiere cambiar la regla.
     * @param int El id de la regla que se quiere establecer para ese evento.
     * @param int El id del usuario que seleccionó una opción en el evento.
     * @return bool True si la operación ha tenido exito, false si no es así.
     */
    public function setEventParticipationRule(int $event_id, int $user_id, int $rule_id):bool
    {
        $status = false;

        // Primero hay que comprobar si hay una regla creada ya para el usuario
        $sql = "SELECT COUNT(*) AS RULE_EXISTS FROM user_event_participation
        WHERE User_id = :user_id";

        $this->connection->execute_select($sql, [":user_id" => $user_id]);
        $exists = $this->connection->rows[0]["RULE_EXISTS"];

        if($exists > 0)
        {
            $sql = "UPDATE user_event_participation SET Rule_id = :rule_id 
            WHERE Event_id = :event_id AND User_id = :user_id";
            $status = $this->connection->execute_query($sql, [
                ":user_id" => $user_id,
                ":event_id" => $event_id,
                ":rule_id" => $rule_id
            ]);
        }
        else
        {
            $sql = "INSERT INTO user_event_participation VALUES(
                :event_id, :user_id, :rule_id
            )";

            $status = $this->connection->execute_query($sql, [
                ":user_id" => $user_id,
                ":event_id" => $event_id,
                ":rule_id" => $rule_id
            ]);
        }

        return $status;
    }
}