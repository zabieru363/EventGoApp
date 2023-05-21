<?php
require_once("../config/displayErrors.php");
require_once("../lib/BaseController.php");
require_once("CityController.php");

final class RegisterController extends BaseController
{
    public function index():void
    {
        try {
            $city_controller = new CityController();
            $cities = $city_controller->listCities();

            $data["cities"] = $cities;
            $this->render("register/registerForm", $data, false);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}