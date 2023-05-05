<?php
require_once("../models/UserModel.php");

final class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = UserModel::getInstance();
        session_start();
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
    public function login(string $user, string $password):array
    {
        $login_status = [
            "message" => "",
            "login" => false
        ];

        if($this->model->checkUser($user, $password))
        {
            $login_status["login"] = true;
        }
        else
        {
            $login_status["message"] = "Usuario o contraseña incorrectos";
        }

        return $login_status;
    }

    /**
     * Inicio de la aplicacion.
     */
    public function listUsers()
    {
        $users = $this->model->getAllUsers();
        require_once("views/register/registerForm.php");
    }
}