<?php
require_once("../models/DAOCategories.php");
require_once("../config/displayErrors.php");

final class CategoryController
{
    private $model;

    public function __construct()
    {
        $this->model = DAOCategories::getInstance();
    }

    public function listCategories()
    {
        $categories = $this->model->list();
        require_once("../views/home/home.php");
    }
}