<?php
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");
require_once(realpath(dirname(__FILE__)) . "/../config/Connection.php");
require_once(realpath(dirname(__FILE__)) . "/entities/Category.php");

final class DAOCategories
{
    private static $instance;
    private Connection $connection;
    private $data = [];

    private function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new DAOCategories();
        }

        return self::$instance;
    }

    /**
     * Método que hace una consulta a la base de datos y crea una categoría.
     * @param Category Un objeto de la clase Category.
     * @return Category Un objeto Category con todos los datos listos. 
     */
    public function create(Category $category):Category
    {
        $sql = "INSERT INTO category VALUES(NULL, :name)";
        $id = $this->connection->execute_query_id($sql, [":name" => $category->__get("name")]);

        $category->__set("id", $id);

        return $category;
    }

    /**
     * Método que hace una consulta para obtener todas las categorías.
     * @return array Un array de objetos Category con todas las categorías.
     */
    public function list():array
    {
        $sql = "SELECT * FROM category";
        $this->connection->execute_select($sql, []);

        foreach($this->connection->rows as $row)
        {
            $category = new Category();

            $category->__set("id", $row["Id"]);
            $category->__set("name", $row["Name"]);

            array_push($this->data, $category);
        }

        return $this->data;
    }

    /**
     * Método que hace una consulta a la base de datos para borrar
     * una categoría.
     * @param int El id de la categoría que se quiere eliminar.
     */
    public function delete(int $id):bool
    {
        // Primero hay que borrar las relaciones con los eventos.
        $sql = "SELECT Event_id FROM category_event WHERE Category_id = :category_id";
        $this->connection->execute_select($sql, [":category_id" => $id]);

        foreach($this->connection->rows as $row)
        {
            $event_id = $row["Event_id"];

            $sql = "DELETE FROM user_event_participation WHERE Event_id = :event_id";
            $this->connection->execute_query($sql, [":event_id" => $event_id]);

            $sql = "DELETE FROM event_images WHERE Event_id = :event_id";
            $this->connection->execute_query($sql, [":event_id" => $event_id]);

            $sql = "DELETE FROM user_event WHERE Id_event = :event_id";
            $this->connection->execute_query($sql, [":event_id" => $event_id]);

            $sql = "DELETE FROM category_event WHERE Category_id = :category_id";
            $this->connection->execute_query($sql, [":category_id" => $id]);

            $sql = "DELETE FROM event WHERE Id = :event_id";
            $this->connection->execute_query($sql, [":event_id" => $event_id]);
        }

        $sql = "DELETE FROM category WHERE Id = :category_id";
        $status = $this->connection->execute_query($sql, [":category_id" => $id]);

        return $status;
    }

    /**
     * Método que comprueba si una categoría existe.
     * @param string El nombre de la categoría.
     * @return bool True si existe, false si no es así.
     */
    public function categoryExists(string $category_name):bool
    {
        $exists = false;

        $sql = "SELECT COUNT(Name) AS CATEGORY_EXISTS FROM category WHERE Name = :category";
        $this->connection->execute_select($sql, [":category" => $category_name]);

        if($this->connection->rows[0]["CATEGORY_EXISTS"] == 1) $exists = true;

        return $exists;
    }
}