<?php

/**
 * Clase que comprueba que controlador cargar dependiendo
 * del parametro que haya pasado el usuario en la url.
 * @author Javier López
 * @version 1.0
 */
final class Dispatcher
{
    public function __construct() {}

    /**
     * Método que comprueba que parametro ha pasado
     * el usuario por la url. Ejecuta el controlador
     * correspondiente, con la vista correspondiente.
     */
    public function dispatch()
    {
        $url = "home";   // Por defecto es home
        $action = "index";  // La acción por defecto es el método index

        if(isset($_GET["url"])) $url = $_GET["url"];
        if(isset($_GET["action"])) $action = $_GET["action"];

        $controller_name = ucfirst($url) . "Controller";
        $route = "controllers/" . $controller_name . ".php";

        if(file_exists($route))
        {
            require_once($route);

            if(class_exists($controller_name))
            {
                $c = new $controller_name();

                if(method_exists($c, $action))
                {
                    $c->$action();
                }
                else
                {
                    require_once("controllers/ErrorController.php");
                    $e_controller = new ErrorController();
                    $e_controller->error();
                }
            }
            else
            {
                require_once("controllers/ErrorController.php");
                $e_controller = new ErrorController();
                $e_controller->error();
            }
        }
        else
        {
            require_once("controllers/ErrorController.php");
            $e_controller = new ErrorController();
            $e_controller->error();
        }
    }
}