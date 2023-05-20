<?php

/**
 * Clase controlador base que servirá para
 * renderizar las diferentes vistas de la aplicación.
 * @author Javier López
 * @version 1.0
 */
class BaseController
{
    /**
     * Método protegido que sirve para que los diferentes
     * controladores puedan cargar vistas con los datos que
     * necesitan del modelo.
     * @param string El nombre de la vista.
     * @param array Un array asociativo con los datos que se
     * quieren enviar a la vista.
     */
    protected function render(string $view, $data = [])
    {
        $route = "..views/" . $view . ".php";

        if(file_exists($route))
        {
            extract($data);
            require_once($route);
        }
        else
        {
            throw new Error("Error: Vista " . $view . " no encontrada.");
        }
    }
}