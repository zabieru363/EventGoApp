<?php
require_once("../config/displayErrors.php");
require_once("../config//Connection.php");
require_once("entities/User.php");

final class UserModel
{
    private static $instance;
    private Connection $connection;
    private $data = [];

    private function __construct()
    {
        $this->connection = Connection::getInstance("eventgo_app");
    }

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new UserModel();
        }

        return self::$instance;
    }

    /**
     * Método que registra un usuario nuevo en la base de datos.
     * @param array Un array con los valores con los que se
     * guardará el usuario en la base de datos.
     */
    public function addUser(User $user):void
    {
        $password_hash = password_hash($user->__get("password"), PASSWORD_BCRYPT);

        $sql = "INSERT INTO user VALUES(NULL, :username, :password,
        :type, :fullname, :email, :country, :city, :active, CURDATE(), :image)";

        $this->connection->execute_query($sql, [
            ":username" => $user->__get("username"),
            ":password" => $password_hash,
            ":type" => $user->__get("type"),
            ":fullname" => $user->__get("fullname"),
            ":email" => $user->__get("email"),
            ":country" => $user->__get("country"),
            ":city" => $user->__get("city"),
            ":active" => $user->__get("active"),
            ":image" => $user->__get("image")
        ]);
    }

    /**
     * Método que comprueba si un nombre de usuario exsite
     * en la base de datos.
     * @param string El nombre de usuario del usuario.
     * @return array Un array asociativo con el mensaje que
     * indica si el nombre de usuario existe y un boolean.
     */
    public function userExists(string $username):array
    {
        $info = [
            "message" => "",
            "exists" => false
        ];

        $sql = "SELECT Username FROM user WHERE Username = :username";
        $this->connection->execute_select($sql, [":username" => $username]);

        if(count($this->connection->rows) > 0)
        {
            $info["message"] = "Este nombre de usuario ya está en uso.";
            $info["exists"] = true;
        }

        return $info;
    }

    /**
     * Método que comprueba si un email exsite
     * en la base de datos.
     * @param string El email del usuario.
     * @return array Un array asociativo con el mensaje que
     * indica si el email existe y un boolean.
     */
    public function emailExists(string $email):array
    {
        $info = [
            "message" => "",
            "exists" => false
        ];

        $sql = "SELECT Email FROM user WHERE Email = :email";
        $this->connection->execute_select($sql, [":email" => $email]);

        if(count($this->connection->rows) > 0)
        {
            $info["message"] = "Esta dirección de correo electrónico ya está en uso.";
            $info["exists"] = true;
        }

        return $info;
    }

    /**
     * Método que obtiene todos los usuarios de la
     * tabla user de la base de datos y los trae al modelo.
     * @return array Un array con todos los usuarios de la
     * base de datos en formato de objeto.
     */
    public function getAllUsers():array
    {
        $sql = "SELECT * FROM user";
        $this->connection->execute_select($sql, []);

        foreach($this->connection->rows as $row)
        {
            $user = new User();

            $user->__set("id", $row["Id"]);
            $user->__set("username", $row["Username"]);
            $user->__set("type", $row["Type"]);
            $user->__set("fullname", $row["Fullname"]);
            $user->__set("email", $row["Email"]);
            $user->__set("country", $row["Country"]);
            $user->__set("city", $row["City"]);
            $user->__set("active", $row["Active"]);
            $user->__set("register_date", $row["Register_date"]);
            $user->__set("image", $row["Image"]);

            array_push($this->data, $user);
        }

        return $this->data;
    }
}