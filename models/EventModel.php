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
     * Método que busca eventos por titulo en base a lo que el usuario
     * escribió en el buscador. Si encuentra algo, trae solo 3 registros
     * para dar la menor carga posible al servidor.
     * @param string Lo que ha introducido el usuario en el formulario.
     * @return array Un array asociativo con el id del evento y el titulo
     * de los eventos que ha encontrado la consulta.
     */
    public function searchEvent(string $search):array
    {
        $sql = "SELECT Id, Title FROM event WHERE Title LIKE :search LIMIT 3";
        $this->connection->execute_select($sql, [":search" => "%" . $search . "%"]);
        $this->data = [];

        foreach($this->connection->rows as $row)
        {
            $new_row = [];

            $new_row["id"] = $row["Id"];
            $new_row["title"] = $row["Title"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que recupera todos los eventos y los
     * guarda en el array privado data.
     * @param int Parametro opcional. Si se pasa tiene que ser
     * un id que identifique al usuario, para saber si la sesión
     * está activa o no. Si no es null traerá todos los eventos junto
     * con las reglas que estableció el usuario. Si es nulo traerá
     * todos los evento sis las reglas.
     * @return array Un array con todos los eventos 
     * Incluye también las imagenes, separadas por el " "
     */
    public function getAllEvents(int $user_id = null):array
    {
        // Si está la sesión iniciada.
        if(!(is_null($user_id)))
        {
            $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
            e.Start_date, e.Ending_date, GROUP_CONCAT(ei.Image SEPARATOR '/') AS
            Image_Name, ce.Category_id AS Category, uep.Rule_id AS Rule, e.Active FROM event e 
            INNER JOIN event_images ei ON e.Id = ei.Event_id
            INNER JOIN city c ON c.Id = e.Location
            INNER JOIN category_event ce ON e.Id = ce.Event_id
            INNER JOIN user_event_participation uep  ON e.Id = uep.Event_id
            WHERE uep.User_id = :user_id
            GROUP BY e.Id;";
    
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
                $new_row["images"] = $row["Image_Name"];
                $new_row["active"] = $row["Active"];
                $new_row["category"] = $row["Category"];
                $new_row["rule"] = $row["Rule"];
    
                array_push($this->data, $new_row);
            }
        }
        else
        {
            $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
            e.Start_date, e.Ending_date, GROUP_CONCAT(ei.Image SEPARATOR '/') AS
            Image_Name, ce.Category_id AS Category, e.Active FROM event e 
            INNER JOIN event_images ei ON e.Id = ei.Event_id
            INNER JOIN city c ON c.Id = e.Location
            INNER JOIN category_event ce ON e.Id = ce.Event_id
            GROUP BY e.Id;";

            $this->connection->execute_select($sql, []);
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
                $new_row["active"] = $row["Active"];
                $new_row["category"] = $row["Category"];

                array_push($this->data, $new_row);
            }
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
    public function setEventParticipationRule(int $event_id, int $user_id):bool
    {
        $sql = "INSERT INTO user_event_participation VALUES(
            :event_id, :user_id, 1
        )";

        $status = $this->connection->execute_query($sql, [
            ":user_id" => $user_id,
            ":event_id" => $event_id
        ]);

        return $status;
    }

    /**
     * Método que actualiza la regla de participación de un evento para un
     * usuario.
     * @param int El id del evento del cuál se quiere cambiar la regla.
     * @param int El id del usuario que quiere participar en el evento.
     * @param int El id de la regla de la opción de participación que escogió el usuario
     * @return bool True si la consulta ha tenido exito, false si no es así.
     */
    public function updateEventParticipationRule(int $event_id, int $user_id, int $rule_id):bool
    {
        $sql = "UPDATE user_event_participation SET Rule_id = :rule_id 
        WHERE Event_id = :event_id AND User_id = :user_id";

        $status = $this->connection->execute_query($sql, [
            ":user_id" => $user_id,
            ":event_id" => $event_id,
            ":rule_id" => $rule_id
        ]);

        return $status;
    }
}