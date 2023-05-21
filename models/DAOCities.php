<?php
require_once("config/displayErrors.php");
require_once("config/Connection.php");
require_once("entities/City.php");

final class DAOCities
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
        $sql = "SELECT * FROM city";
        $this->connection->execute_select($sql, []);

        foreach($this->connection->rows as $row)
        {
            $city = new City();

            $city->__set("id", $row["Id"]);
            $city->__set("name", $row["Name"]);

            array_push($this->data, $city);
        }

        return $this->data;
    }
}