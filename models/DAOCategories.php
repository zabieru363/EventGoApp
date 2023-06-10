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
        $id = $this->connection->execute_query_id($sql, [":name", $category->__get("name")]);

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
        $sql = "DELETE FROM category WHERE Id = :category_id";
        $status = $this->connection->execute_query($sql, [":category_id" => $id]);

        return $status;
    }
}