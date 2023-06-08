<?php
require_once("controllers/UserController.php");

final class ForgotPasswordController extends BaseController
{
    public function index()
    {
        try {
            $user_controller = new UserController();
            $this->render("forgot_password/forgotPassword");
        }catch(Exception $e) {
            var_dump($e);
        }
    }
}