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
        $sql = "SELECT Id, Title FROM event WHERE Title LIKE :search AND Active = 1 LIMIT 3";
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
        e.Start_date, e.Ending_date, e.Active FROM event e 
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
            $new_row["active"] = $row["Active"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que obtiene los eventos en los que el usuario va
     * a participar.
     * @param int El id del usuario del que se quieren obtener
     * los eventos en los cuáles va a participar.
     * @return array Los eventos en los cuáles va a participar el usuario.
     */
    public function getUserEventsParticipation(int $user_id):array
    {
        $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
        e.Start_date, e.Ending_date, e.Active FROM event e 
        INNER JOIN user_event_participation uep ON e.Id = uep.Event_id
        INNER JOIN user u ON uep.User_id = u.Id
        INNER JOIN city c ON c.Id = e.Location
        WHERE u.Id = :user_id AND uep.Rule_id = 2";

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
            $new_row["active"] = $row["Active"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que obtiene los eventos en los que el usuario no va
     * a participar.
     * @param int El id del usuario del que se quieren obtener
     * los eventos en los cuáles no va a participar.
     * @return array Los eventos en los cuáles no va a participar el usuario.
     */
    public function getUserCancelledEvents(int $user_id):array
    {
        $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
        e.Start_date, e.Ending_date, e.Active FROM event e 
        INNER JOIN user_event_participation uep ON e.Id = uep.Event_id
        INNER JOIN user u ON uep.User_id = u.Id
        INNER JOIN city c ON c.Id = e.Location
        WHERE u.Id = :user_id AND uep.Rule_id = 3";

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
            $new_row["active"] = $row["Active"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que obtiene los eventos en los que el usuario tiene
     * que confirmar si va a ir o no.
     * @param int El id del usuario del que se quieren obtener
     * los eventos en los cuáles no sabe si va a participar.
     * @return array Los eventos en los cuáles el usuario no sabe si va a participar.
     */
    public function getUserPendingEvents(int $user_id):array
    {
        $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
        e.Start_date, e.Ending_date, e.Active FROM event e 
        INNER JOIN user_event_participation uep ON e.Id = uep.Event_id
        INNER JOIN user u ON uep.User_id = u.Id
        INNER JOIN city c ON c.Id = e.Location
        WHERE u.Id = :user_id AND uep.Rule_id = 4";

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
            $new_row["active"] = $row["Active"];

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
        $sql = "INSERT INTO user_event_participation VALUES(
            :event_id, :user_id, :rule_id
        )";

        $status = $this->connection->execute_query($sql, [
            ":user_id" => $user_id,
            ":event_id" => $event_id,
            ":rule_id" => $rule_id
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

    public function eventParticipationRuleExists(int $event_id, int $user_id):bool
    {
        $exists = false;

        $sql = "SELECT Rule_id FROM user_event_participation
        WHERE Event_id = :event_id AND User_id = :user_id";
        $this->connection->execute_select($sql, [
            ":event_id" => $event_id,
            ":user_id" => $user_id 
        ]);

        if(count($this->connection->rows) > 0) $exists = true;

        return $exists;
    }

    /**
     * Método que va obteniendo eventos con una consulta en base
     * a un limitador que se le pasa cómo parametro.
     * @param int Desde donde empieza a sacar registros.
     * @param int Hasta donde termina de sacar registros.
     * @return array Un array asociativo que contiene los eventos que ha
     * devuelto la consulta con todos sus datos.
     */
    public function listEvents(int $start, int $end):array
    {
        $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
        e.Start_date, e.Ending_date, cat.Name AS Category, e.Active FROM event e 
        INNER JOIN event_images ei ON e.Id = ei.Event_id
        INNER JOIN city c ON c.Id = e.Location
        INNER JOIN category_event ce ON e.Id = ce.Event_id
        INNER JOIN category cat ON cat.Id = ce.Category_id
        GROUP BY e.Id
        LIMIT " . $start . "," . $end;

        $this->connection->execute_select($sql, []);
        $this->data = [];

        foreach($this->connection->rows as $row)
        {
            $new_row = [];

            $new_row["id"] = $row["Id"];
            $new_row["title"] = $row["Title"];
            $new_row["description"] = $row["Description"];
            $new_row["admin"] = $row["Admin"];
            $new_row["city"] = $row["City_Name"];
            $new_row["start_date"] = $row["Start_date"];
            $new_row["ending_date"] = $row["Ending_date"];
            $new_row["category"] = $row["Category"];
            $new_row["active"] = $row["Active"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que devuelve el número total de eventos
     * que hay en la tabla event.
     * @return int El número total de eventos que hay.
     */
    public function getNumberofTotalEvents():int
    {
        $sql = "SELECT COUNT(Id) AS TOTAL_EVENTS FROM event";
        $this->connection->execute_select($sql, []);

        return $this->connection->rows[0]["TOTAL_EVENTS"];
    }

    /**
     * Método que permite eliminar un evento de la base
     * de datos junto con todas sus relaciones.
     * @param int El id del evento que se quiere eliminar.
     * @return bool True si se ha eliminado, false si no es así.
     */
    public function deleteEvent(int $event_id):bool
    {
        // Antes hay que deshacer las relaciones de los eventos con las otras tablas
        $sql = "DELETE FROM category_event WHERE Event_id = :event_id";
        $this->connection->execute_query($sql, [":event_id" => $event_id]);
        
        $sql = "DELETE FROM event_images WHERE Event_id = :event_id";
        $this->connection->execute_query($sql, [":event_id" => $event_id]);
        
        $sql = "DELETE FROM user_event_participation WHERE Event_id = :event_id";
        $this->connection->execute_query($sql, [":event_id" => $event_id]);
        
        $sql = "DELETE FROM user_event WHERE Id_event = :event_id";
        $this->connection->execute_query($sql, [":event_id" => $event_id]);
        
        $sql = "DELETE FROM event WHERE Id = :event_id";
        $rmeoved = $this->connection->execute_query($sql, [":event_id" => $event_id]);

        return $rmeoved;
    }

    /**
     * Método que desactiva un evento en especifico.
     * @param int El id del evento que se quiere desactivar.
     * @return bool True si se ha desactivado, false si no es así.
     */
    public function banEvent(int $event_id):bool
    {
        $sql = "UPDATE event SET Active = 0 WHERE Id = :event_id";
        $disabled = $this->connection->execute_query($sql, [":event_id" => $event_id]);

        return $disabled;
    }

    /**
     * Método que activa un usuario en especifico.
     * @param int El id del usuario que se quiere activar.
     * @return bool True si se ha activado, false si no es así.
     */
    public function activeEvent(int $event_id):bool
    {
        $sql = "UPDATE event SET Active = 1 WHERE Id = :event_id";
        $activated = $this->connection->execute_query($sql, [":event_id" => $event_id]);

        return $activated;
    }

    /**
     * Método que recupera un evento por id de usuario y por
     * id de evento.
     * @param int El id de usuario que realiza la búsqueda, si
     * es nulo no se traerá la regla.
     * @param int El id del evento que se recuperó de la busqueda.
     * @return array Un array asociativo con los datos del evento
     * en base al id que se pasó cómo parametro.
     */
    public function getEventById(int $event_id, int $user_id = 0):array
    {
        $event = [];

        if($user_id == 0)
        {
            $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
                e.Start_date, e.Ending_date, GROUP_CONCAT(ei.Image SEPARATOR '/') AS
                Image_Name FROM event e 
                INNER JOIN event_images ei ON e.Id = ei.Event_id
                INNER JOIN city c ON c.Id = e.Location
                INNER JOIN category_event ce ON e.Id = ce.Event_id
                WHERE e.Id = :event_id AND e.Active = 1";

            $this->connection->execute_select($sql, [":event_id" => $event_id]);
            $this->data = [];

            $event["id"] = $this->connection->rows[0]["Id"];
            $event["title"] = $this->connection->rows[0]["Title"];
            $event["description"] = $this->connection->rows[0]["Description"];
            $event["admin"] = $this->connection->rows[0]["Admin"];
            $event["city"] = $this->connection->rows[0]["City_Name"];
            $event["start_date"] = $this->connection->rows[0]["Start_date"];
            $event["ending_date"] = $this->connection->rows[0]["Ending_date"];
            $event["images"] = $this->connection->rows[0]["Image_name"];
        }
        else
        {
            $sql = "SELECT e.Id, e.Title, e.Description, e.Admin, c.Name AS City_Name,
                e.Start_date, e.Ending_date, GROUP_CONCAT(ei.Image SEPARATOR '/') AS
                Image_Name, uep.Rule_id AS Rule FROM event e 
                INNER JOIN event_images ei ON e.Id = ei.Event_id
                INNER JOIN city c ON c.Id = e.Location
                INNER JOIN category_event ce ON e.Id = ce.Event_id
                INNER JOIN user_event_participation uep  ON e.Id = uep.Event_id
                WHERE uep.User_id = :user_id AND e.Id = :event_id
                AND e.Active = 1";
            
            $this->connection->execute_select($sql, [
                ":user_id" => $user_id,
                ":event_id" => $event_id
            ]);
            $this->data = [];
    
            $event["id"] = $this->connection->rows[0]["Id"];
            $event["title"] = $this->connection->rows[0]["Title"];
            $event["description"] = $this->connection->rows[0]["Description"];
            $event["admin"] = $this->connection->rows[0]["Admin"];
            $event["city"] = $this->connection->rows[0]["City_name"];
            $event["start_date"] = $this->connection->rows[0]["Start_date"];
            $event["ending_date"] = $this->connection->rows[0]["Ending_date"];
            $event["images"] = $this->connection->rows[0]["Image_name"];
            $event["rule"] = $this->connection->rows[0]["Rule"];
        }

        return $event;
    }
}