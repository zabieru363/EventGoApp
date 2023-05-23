<?php
require_once("UserController.php");

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

            if(isset($_SESSION["id_user"]))
            {
                $user_data = $user_controller->getUserProfileData($_SESSION["id_user"]);
                $city_name = $user_controller->getUserCity($user_data["city"]);
                $this->render("user_profile/profile", [
                    "user_data" => $user_data,
                    "city_name" => $city_name
                ]);
            }
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}