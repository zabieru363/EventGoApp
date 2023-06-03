<?php
require_once("UserController.php");

final class LogoutController extends BaseController
{
    /**
     * Método que crea la vista para el login
     */
    public function index():void
    {
        if(isset($_SESSION["id_user"]))
        {
            try{
                $user_controller = new UserController();
    
                if(isset($_COOKIE["remember_me"]))
                {
                    setcookie("remember_me", "", time() - 3600);
                    $user_controller->deleteToken($_SESSION["id_user"]);
                }
    
                unset($_SESSION["id_user"]);
                unset($_SESSION["username"]);
    
                session_destroy();
    
                // Finalmente se redirecciona al index.php
                header('Refresh: 2; url=index.php');
            }catch(Exception $e){
                var_dump($e->getMessage());
            }
        }
        else
        {
            header("Location: index.php?url=login");
        }
    }
}