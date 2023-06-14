<?php

final class ErrorController extends BaseController
{
    public function __construct() {}

    public function error()
    {
        try {
            $this->render("error/error");
        }catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }
}