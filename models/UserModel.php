<?php
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");
require_once(realpath(dirname(__FILE__)) . "/../config/Connection.php");
require_once(realpath(dirname(__FILE__)) . "/entities/User.php");

final class UserModel
{
    private static $instance;
    private Connection $connection;
    private $data = [];

    private function __construct()
    {
        $this->connection = Connection::getInstance();
        session_start();
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
     * @param User Un objeto usuario creado previamente con
     * los datos que se introdujeron en el formulario de registro
     * cómo propiedades.
     */
    public function addUser(User $user):void
    {
        $password_hash = password_hash($user->__get("password"), PASSWORD_BCRYPT);

        $sql = "INSERT INTO user VALUES(NULL, :username, :password,
        :type, :fullname, :email, :city, :active, CURDATE(), :image)";

        $this->connection->execute_query($sql, [
            ":username" => $user->__get("username"),
            ":password" => $password_hash,
            ":type" => $user->__get("type"),
            ":fullname" => $user->__get("fullname"),
            ":email" => $user->__get("email"),
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
     * Método que recupera todas las provincias de
     * España de la tabla city y las guarda en un array.
     * @return array Un array con las provincias de España. 
     */
    public function getCities():array
    {
        $cities = [];

        $sql = "SELECT * FROM city";
        $this->connection->execute_select($sql, []);

        foreach($this->connection->rows as $row)
        {
            array_push($cities, $row["Name"]);
        }

        return $cities;
    }

    /**
     * Método que comprueba si el usuario o email y contraseña
     * que ha introducido el usuario el formulario de inicio
     * de sesión es correcto con una consulta a la base de datos.
     * @param string El nombre de usuario o email introducido.
     * @param string La contraseña introducida.
     * @return bool Devuelve true si el usuario fue encontrado
     * false si no fue así.
     */
    public function checkUser(string $user, string $password, bool $remember_me):bool
    {
        $login = false;

        $sql = "SELECT Id, Username, Password_hash FROM user 
        WHERE Username = :user  OR Email = :user";

        $this->connection->execute_select($sql, [":user" => $user]);

        foreach($this->connection->rows as $row)
        {
            if(password_verify($password, $row["Password_hash"]))
            {
                $login = true;
                $_SESSION["id_user"] = $row["Id"];
                $_SESSION["username"] = $row["Username"];

                $this->deleteExpiredTokens();

                if($remember_me)
                {
                    $token = bin2hex(random_bytes(32));
                    $seconds = 30 * 24 * 60 * 60;   // 30 dias en segundos
                    $now = time();
                    $expiration = $now + $seconds;
                    $expiration_date = date('Y-m-d H:i:s', $expiration);

                    $sql = "INSERT INTO remember_token VALUES(NULL,
                    :user_id, :token, :expiry)";

                    $this->connection->execute_query($sql, [
                        ":user_id" => $row["Id"],
                        ":token" => $token,
                        ":expiry" => $expiration_date
                    ]);

                    setcookie('remember_me', $token, $expiration, '/');
                }
            }
        }

        return $login;
    }

    /**
     * Método que elimina el token de autenticación del usuario
     * para cuando inicia sesión.
     * @param int El id del usuario del que se quiere eliminar el token
     */
    public function deleteToken(int $user_id):void
    {
        $sql = "DELETE FROM remember_token WHERE User_id = :id";
        $this->connection->execute_query($sql, [":id" => $user_id]);
    }

    /**
     * Método que elimina los registros de la tabla de
     * remember_tokens en los que la fecha de expiración
     * haya llegado a la fecha de hoy.
     */
    private function deleteExpiredTokens():void
    {
        $sql = "DELETE FROM remember_token WHERE Expiry <= NOW()";
        $this->connection->execute_query($sql, []);
    }

    /**
     * Método que hace una consulta a la base de datos para
     * traerse el nombre del archivo de la imagen del usuario.
     * @param int El id de usuario al que corresponde la foto.
     * @return string El nombre de la imagen de ese usuario.
     */
    public function getUserImage(int $user_id):string
    {
        $sql = "SELECT Image FROM user WHERE Id = :id";
        $this->connection->execute_select($sql, [":id" => $user_id]);

        $file_name = "";

        foreach($this->connection->rows as $row)
        {
            $file_name = $row["Image"];
        }

        return $file_name;
    }

    /**
     * Método que recupera los datos para el perfil
     * de un usuario en especifico.
     * @param int El id del usuario del cuál se quieren
     * recuperar los datos.
     * @return array Un array asociativo el cuál
     * contiene los datos del usuario extraidos de la consulta.
     */
    public function getUserData(int $user_id):array
    {
        $data = [
            "username" => "",
            "fullname" => "",
            "email" => "",
            "city" => 0,
            "image" => ""
        ];

        $sql = "SELECT user.Name, user.Email, city.Name AS city_name, user.Image
        FROM user JOIN city ON user.City = city.Id
        WHERE user.Id = :id";
        $this->connection->execute_select($sql, [":id" => $user_id]);

        foreach($this->connection->rows as $row)
        {
            $data["username"] = $row["Username"];
            $data["fullname"] = $row["Name"];
            $data["email"] = $row["Email"];
            $data["city"] = $row["city_name"];
            $data["image"] = $row["Image"];
        }

        return $data;
    }

    public function changeUserData(int $user_id, array $new_values):bool
    {
        $updated = false;

        if($new_values["Image"] !== "")
        {
            $sql = "UPDATE user SET Username = :username, Name = :fullname,
            Email = :email, Image = :image WHERE Id = :id";
            $updated = $this->connection->execute_query($sql, [
                ":username" => $new_values["username"],
                ":fullname" => $new_values["name"],
                ":email" => $new_values["email"],
                ":image" => $new_values["Image"],
                ":id" => $user_id
            ]);
        }
        else
        {
            $sql = "UPDATE user SET Username = :username, Name = :fullname,
            Email = :email WHERE Id = :id";
            $updated = $this->connection->execute_query($sql, [
                ":username" => $new_values["username"],
                ":fullname" => $new_values["name"],
                ":email" => $new_values["email"],
                ":id" => $user_id
            ]);
        }

        return $updated;
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