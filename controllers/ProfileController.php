<?php
require_once("UserController.php");
require_once("CityController.php");

final class ProfileController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = UserModel::getInstance();
    }

    public function index()
    {
        try {
            $user_controller = new UserController();
            $city_controller = new CityController();

            if(isset($_SESSION["id_user"]))
            {
                $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);
                $user_image = $user_controller->setUserImage($_SESSION["id_user"]);
                $cities = $city_controller->listCities();
                $this->render("user_profile/profile", [
                    "user_data" => $user_data,
                    "user_image" => $user_image,
                    "cities" => $cities
                ]);
            }
            else
            {
                header("Location: index.php?url=login");
            }
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}