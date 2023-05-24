<?php
require_once("CityController.php");

final class EventController extends BaseController
{
    public function index()
    {
        try{
            $this->render("create_event/create_event");
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }
}