<?php
require_once("UserController.php");

final class UserProfileController extends BaseController
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
                $this->render("user_profile/profile", ["user_data" => $user_data]);
            }
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}