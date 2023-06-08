<?php
require_once("UserController.php");

final class LoginController extends BaseController
{
    /**
     * Método que crea la vista para el login
     */
    public function index():void
    {
        $user_controller = new UserController();
        
        if(isset($_SESSION["id_user"]))
        {
            header("Location: index.php");
        }
        else
        {
            try{
                $this->render("login/loginForm");
            }catch(Exception $e){
                var_dump($e->getMessage());
            }
        }
    }
}