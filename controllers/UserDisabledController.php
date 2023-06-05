<?php

final class UserDisabledController extends BaseController
{
    public function __construct() {}

    public function index():void
    {
        if(isset($_SESSION["id_user"]))
        {
            header("Location: index.php");
        }
        else
        {
            try{
                $this->render("user_disabled/userDisabled");
            }catch(Exception $e) {
                var_dump($e->getMessage());
            }
        }
    }
}