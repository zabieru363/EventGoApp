<?php
require_once("CityController.php");

final class EventController extends BaseController
{
    /**
     * Método que carga la vista con un formulario
     * para crear un evento.
     */
    public function create()
    {
        try{
            $this->render("create_event/create_event");
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }
}