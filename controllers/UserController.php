<?php
require_once(realpath(dirname(__FILE__)) . "/../models/UserModel.php");

final class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = UserModel::getInstance();
    }

    /**
     * Método que comunica al modelo la acción de registrar
     * el usuario. Si el nombre de usuario o el email ya
     * existen no lo manda a insertar en la base de datos.
     * @param User Un objeto usuario previamente creado
     * para obtener las diferentes propiedades.
     * @return array Un array asociativo indicando si ha
     * insertado al usuario y si el registro contiene
     * algunos errores.
     */
    public function createUser(User $user):array
    {
        $username_info = $this->model->userExists($user->__get("username"));
        $email_info = $this->model->emailExists($user->__get("email"));

        $info = [
            "username_info_message" => $username_info["message"],
            "email_info_message" => $email_info["message"],
            "created" => false
        ];

        if(!($username_info["exists"]) && !($email_info["exists"]))
        {
            $this->model->addUser($user);
            $info["created"] = true;
        }

        return $info;
    }

    /**
     * Método que llama al modelo y comprueba si el
     * nombre de usuario que se le pasa cómo parámetro
     * existe.
     * @param string El nombre de usuario a comprobar.
     * @return array Un array asociativo que contiene
     * un boolean que indica si el usuario existe y
     * un mensaje que indica si ha habido algún error.
     */
    public function usernameExists(string $user):array
    {
        return $this->model->userExists($user);
    }

    /**
     * Método que llama al modelo y comprueba si el
     * email que se le pasa cómo parámetro existe.
     * @param string El email a comprobar.
     * @return array Un array asociativo que contiene
     * un boolean que indica si el email existe y
     * un mensaje que indica si ha habido algún error.
     */
    public function emailExists(string $email):array
    {
        return $this->model->emailExists($email);
    }

    /**
     * Método que comprueba si el login es correcto
     * llamando al modelo.
     * @param string El nombre de usuario o el email
     * introducido para iniciar sesión.
     * @param string La contraseña introducida para
     * iniciar sesión.
     * @return array Un array asociativo indicando
     * con propiedades indicando si el login ha
     * tenido exito o no.
     */
    public function login(string $user, string $password, bool $remember_me):array
    {
        $login_status = [
            "message" => "Usuario o contraseña incorrectos",
            "active" => false,
            "login" => false
        ];

        $user_info = $this->model->checkUser($user, $password, $remember_me);

        if($user_info["login"])
        {
            $login_status["login"] = true;
            $login_status["message"] = "";

            if($user_info["active"]) $login_status["active"] = true;
        }

        return $login_status;
    }

    /**
     * Método que restaura la sesión del usuario si la cookie
     * de remember me todavía no ha expirado.
     */
    public function restoreUserSession():void
    {
        if(isset($_COOKIE["remember_me"]))
        {
            $token = $_COOKIE["remember_me"];
            $result = $this->model->tokenExists($token);

            if($result["token_exists"])
            {
                $_SESSION["id_user"] = $result["user_id"];
                $_SESSION["username"] = $result["username"];
            }
        }
    }

    /**
     * Método que llama al modelo para eliminar el token
     * de autenticación del usuario
     * @param int El id del usuario del cuál se quiere
     * eliminar el token.
     */
    public function deleteToken(int $user_id):void
    {
        $this->model->deleteToken($user_id);
    }

    /**
     * Método que llama al modelo para recuperar
     * la imagen del usuario.
     * @param int El id de usuario del que se quiere
     * recuperar la imagen.
     * @return string El nombre de la imagen de ese usuario.
     */
    public function setUserImage(int $user_id):string
    {
        return $this->model->getUserImage($user_id);
    }

    /**
     * Método que llama al modelo de usuario y ejecuta el
     * método getUserData que recupera la información en
     * base al id de usuario que se le ha pasado.
     * @param int El id del usuario del cuál se quieren
     * obtener los datos.
     * @return array Un array asociativo con los datos
     * correspondientes a ese usuario.
     */
    public function getUserProfileData(int $user_id):array
    {
        return $this->model->getUserData($user_id);
    }

    /**
     * Método que llama al modelo para comprobar si una
     * cuenta de uusario está activa o no.
     * @param int El id del usuario del cuál se quiere saber
     * si su cuenta está activa o no.
     * @return bool True si está activo, false si no es así.
     */
    public function isUserActive(int $user_id):bool
    {
        return $this->model->isUserActive($user_id);
    }

    /**
     * Método que manda al modelo la acción de cambiar los
     * datos de perfil de usuario (los que haya rellenado el usuario)
     * @param int El id del usuario del cuál se quieren cambiar los datos.
     * @param array Un array asociativo con los valores que introdujo el
     * usuario en el formulario de edición de perfil.
     */
    public function updateUser(int $user_id, array $new_values):array
    {
        return $this->model->changeUserData($user_id, $new_values);
    }

    /**
     * Método que llama al modelo para reestablecer la contraseña del
     * usuario.
     * @param string El email del usuario del cuál se quiere reestablecer la contraseña.
     * @param string La nueva contraseña que introdujo el usuario en el formulario
     * de reestablecer contraseña.
     */
    public function resetUserPassword(string $email, string $password):array
    {
        return $this->model->resetUserPassword($email, $password);
    }

    /**
     * Método que recupera todos los usuarios llamando
     * al modelo, previamente ya extraidos de la tabla user.
     */
    public function listUsers(int $page, int $perPage):array
    {
        $start = ($page - 1) * $perPage;
        $end = $start + $perPage;
        $total_rows = $this->getNumberTotalUsers();
        $total_pages = ceil($total_rows / $perPage);

        $users = $this->model->getAllUsers($start, $end);

        return [
            "users" => $users,
            "pagination" => [
                "total_pages" => $total_pages,
                "current_page" => $page,
                "events_per_page" => $perPage,
                "total_events" => $total_rows
            ]
        ];
    }

    /**
     * Método que llama al modelo para eliminar un usuario.
     * @param int El id del usuario que se quiere eliminar.
     * @return bool True si se ha eliminado, false si no es así.
     */
    public function deleteUser(int $user_id):bool
    {
        return $this->model->deleteUser($user_id);
    }

    /**
     * Método que llama al modelo para desactivar un usuario.
     * @param int El id del usuario que se quiere desactivar.
     * @return bool True si se ha desactivado, false si no es así.
     */
    public function banUser(int $user_id):bool
    {
        return $this->model->banUser($user_id);
    }

    /**
     * Método que llama al modelo para activar un usuario.
     * @param int El id del usuario que se quiere activar.
     * @return bool True si se ha activado, false si no es así.
     */
    public function activateUser(int $user_id):bool
    {
        return $this->model->activeUser($user_id);
    }

    /**
     * Método que llama al modelo para recuperar el número de
     * usuarios que hay en la tabla user.
     * @return int El número de usuarios que hay en la tabla user.
     */
    public function getNumberTotalUsers():int
    {
        return $this->model->getNumberTotalUsers();
    }
}