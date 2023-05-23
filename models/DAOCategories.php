<?php
require_once(realpath(dirname(__FILE__)) . "../config/displayErrors.php");
require_once(realpath(dirname(__FILE__)) . "../config/Connection.php");
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
}