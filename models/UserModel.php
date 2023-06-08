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
     * Método que comprueba si el usuario o email y contraseña
     * que ha introducido el usuario el formulario de inicio
     * de sesión es correcto con una consulta a la base de datos.
     * @param string El nombre de usuario o email introducido.
     * @param string La contraseña introducida.
     * @return bool Devuelve true si el usuario fue encontrado
     * false si no fue así.
     */
    public function checkUser(string $user, string $password, bool $remember_me):array
    {
        $user_info = [
            "login" => false,
            "active" => false
        ];

        $sql = "SELECT Id, Username, Password_hash, Active FROM user 
        WHERE Username = :user  OR Email = :user";

        $this->connection->execute_select($sql, [":user" => $user]);

        if(count($this->connection->rows) > 0)
        {
            $user_id = $this->connection->rows[0]["Id"];
            $username = $this->connection->rows[0]["Username"];
            $password_hash = $this->connection->rows[0]["Password_hash"];
            $active = $this->connection->rows[0]["Active"];
    
            if(password_verify($password, $password_hash))
            {
                $user_info["login"] = true;
                
                if($active === 1)
                {
                    $user_info["active"] = true;
                    $_SESSION["id_user"] = $user_id;
                    $_SESSION["username"] = $username;
    
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
                            ":user_id" => $user_id,
                            ":token" => $token,
                            ":expiry" => $expiration_date
                        ]);
    
                        setcookie('remember_me', $token, $expiration, '/');
                    }
                }
            }
        }

        return $user_info;
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
            $data["fullname"] = $row["Name"];
            $data["email"] = $row["Email"];
            $data["city"] = $row["city_name"];
            $data["image"] = $row["Image"];
        }

        return $data;
    }

    /**
     * Método que comprueba si una cuenta de usuario está activo o no.
     * @param int El id del usuario que se quiere comprobar si está activo o no
     * @return bool True si está activo, false si no es así.
     */
    public function isUserActive(int $user_id):bool
    {
        $is_active = false;

        $sql = "SELECT Active FROM user WHERE Id = :user_id";
        $this->connection->execute_select($sql, [":user_id" => $user_id]);

        $active = $this->connection->rows[0]["Active"];

        if($active === 1) $is_active = true;

        return $is_active;
    }

    /**
     * Método que permite actualizar cualquier campo del perfil
     * del usuario (concretamente, la contraseña, el nombre completo,
     * la imagen o la ciudad)
     * @param int El id de usuario que corresponde al usuario
     * del cuál se quieren actualizar los datos.
     * @param array Los nuevos valores para los campos.
     * @return array Un array con los campos actualizados
     */
    public function changeUserData(int $user_id, array $new_values):array
    {
        $fields = [];
        $params = [];
        $updated_fields = [];

        $sql = "UPDATE user SET ";

        foreach($new_values as $key => $value)
        {
            if(!(empty($value)))
            {
                $fields[] = "$key = :$key";
                $params[":$key"] = is_numeric($value) ? intval($value) : $value;
                $updated_fields[$key] = $value;
            }
        }

        $sql .= implode(", ", $fields);
        $sql .= " WHERE Id = :id";
        $params[':id'] = $user_id;

        $this->connection->execute_query($sql, $params);

        return $updated_fields;
    }

    /**
     * Método que permite cambiar la contraseña del usuario.
     * @param string El email del usuario del cuál se quiere reestablecer la contraseña.
     * @param string La nueva contraseña que escribió el usuario en el
     * formulario de reestablecer contraseña.
     * @return bool True si la consulta ha tenido exito, false si no es así.
     */
    public function resetUserPassword(string $email, string $password):array
    {
        $info = [
            "status" => false,
            "message" => ""
        ];

        // Primero hay que comprobar si la contraseña que ya tiene puesta el usuario es igual a la que ha escrito.
        $sql = "SELECT Password_hash FROM user WHERE Email = :email";
        $this->connection->execute_select($sql, [
            ":email" => $email
        ]);

        if(count($this->connection->rows) > 0)
        {
            $password_bd = $this->connection->rows[0]["Password_hash"];
            $equals = password_verify($password, $password_bd);
    
            if($equals)
            {
                $info["message"] = "La contraseña que has escrito no puede ser igual a la actual";
            }
            else
            {
                $new_password = password_hash($password, PASSWORD_BCRYPT);
    
                $sql = "UPDATE user SET Password_hash = :password WHERE Email = :email";
                $this->connection->execute_query($sql, [
                    ":password" => $new_password,
                    ":email" => $email
                ]);
    
                $info["status"] = true;
                $info["message"] = "Tu contraseña ha sido cambiada. Ya puedes iniciar sesión con tu nueva contraseña.";
            }
        }


        return $info;
    }

    /**
     * Método que obtiene todos los usuarios de la
     * tabla user de la base de datos y los trae al modelo.
     * @return array Un array con todos los usuarios de la
     * base de datos en formato de objeto.
     */
    public function getAllUsers($start, $rows_per_page):array
    {
        $sql = "SELECT u.Id, u.Username, u.Type, u.Name, u.Email, city.Name AS City_name, u.Active, u.Register_date 
        FROM user u JOIN city ON u.City = city.Id
        LIMIT :start, :rows_per_page";
        $this->connection->execute_select($sql, [
            ":start" => $start,
            ":rows_per_page" => $rows_per_page
        ]);
        $this->data = [];

        foreach($this->connection->rows as $row)
        {
            $new_row = [];

            $new_row["id"] = $row["Id"];
            $new_row["username"] = $row["Username"];
            $new_row["type"] = $row["Type"];
            $new_row["name"] = $row["Name"];
            $new_row["email"] = $row["Email"];
            $new_row["city"] = $row["City_name"];
            $new_row["active"] = $row["Active"];
            $new_row["register_date"] = $row["Register_date"];

            array_push($this->data, $new_row);
        }

        return $this->data;
    }

    /**
     * Método que elimina un usuario en especifico.
     * @param int El id del usuario que se quiere eliminar.
     * @return bool True si se ha eliminado, false si no es así.
     */
    public function deleteUser(int $user_id):bool
    {
        // Antes hay que borrar las relaciones con las tablas relacionadas a usuarios
        $sql = "DELETE FROM user_event WHERE Id_user = :user_id";
        $this->connection->execute_query($sql, [":user_id" => $user_id]);

        $sql = "DELETE FROM user_event_participation WHERE User_id = :user_id";
        $this->connection->execute_query($sql, [":user_id" => $user_id]);

        $sql = "DELETE FROM user WHERE Id = :user_id";
        $removed = $this->connection->execute_query($sql, [":user_id" => $user_id]);

        return $removed;
    }

    /**
     * Método que desactiva un usuario en especifico.
     * @param int El id del usuario que se quiere desactivar.
     * @return bool True si se ha desactivado, false si no es así.
     */
    public function banUser(int $user_id):bool
    {
        $sql = "UPDATE user SET Active = 0 WHERE Id = :user_id";
        $disabled = $this->connection->execute_query($sql, [":user_id" => $user_id]);

        return $disabled;
    }

    /**
     * Método que activa un usuario en especifico.
     * @param int El id del usuario que se quiere activar.
     * @return bool True si se ha activado, false si no es así.
     */
    public function activeUser(int $user_id):bool
    {
        $sql = "UPDATE user SET Active = 1 WHERE Id = :user_id";
        $activated = $this->connection->execute_query($sql, [":user_id" => $user_id]);

        return $activated;
    }

    /**
     * Método que devuelve el total de usuarios que hay en la tabla de usuarios
     * @return int El total de usuarios que hay en la tabla user.
     */
    public function getNumberTotalUsers():int
    {
        $sql = "SELECT COUNT(Id) TOTAL_USERS FROM user";
        $this->connection->execute_select($sql, []);

        return count($this->connection->rows);
    }
}