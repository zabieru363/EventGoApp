<?php
require_once("../models/UserModel.php");

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
     * @param array Un array asociativo con los valores
     * que tendrá el usuario.
     * @return array Un array asociativo indicando si ha
     * insertado al usuario y si el registro contiene
     * algunos errores.
     */
    public function createUser(array $values):array
    {
        $username_info = $this->model->userExists($values["username"]);
        $email_info = $this->model->emailExists($values["email"]);

        $info = [
            "username_info_message" => $username_info["message"],
            "email_info_message" => $email_info["message"],
            "created" => false
        ];

        if(!($username_info["exists"]) && !($email_info["exists"]))
        {
            $this->model->addUser($values);
            $info["created"] = true;
        }

        return $info;
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