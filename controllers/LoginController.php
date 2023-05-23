<?php

final class LoginController extends BaseController
{
    /**
     * Método que crea la vista para el login
     */
    public function index():void
    {
        try{
            $this->render("login/loginForm");
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}