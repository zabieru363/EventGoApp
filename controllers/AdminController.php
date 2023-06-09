<?php
require_once("UserController.php");
require_once("EventController.php");

final class AdminController extends BaseController
{
    public function __construct() {}

    /**
     * Método que crea una vista de administración para poder
     * administrar la tabla de usuarios.
     */
    public function users():void
    {
        $user_controller = new UserController();

        if(isset($_SESSION["id_user"]))
        {
            try {
                $users = $user_controller->listUsers();
                $this->render("backoffice/usersAdminZone", ["users" => $users]);
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php");
        }
    }

    /**
     * Método que crea una vista de administración para poder
     * administrar la tabla de eventos.
     */
    public function events():void
    {
        $event_controller = new EventController();

        if(isset($_SESSION["id_user"]))
        {
            try {
                $page = $_GET["page"] ?? 1;
                $params = $event_controller->listEvents($page, 10);
                $this->render("backoffice/eventsAdminZone", ["params" => $params]);
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php");
        }
    }
}