<?php
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");
require_once("CityController.php");
require_once("UserController.php");

final class RegisterController extends BaseController
{
    public function index():void
    {
        $user_controller = new UserController();
        
        if(isset($_SESSION["id_user"]))
        {
            header("Location: index.php");
        }
        else
        {
            try {
                $city_controller = new CityController();
                $cities = $city_controller->listCities();
    
                $data["cities"] = $cities;
                $this->render("register/registerForm", $data);
            }catch(Exception $e){
                var_dump($e->getMessage());
            }
        }
    }
}