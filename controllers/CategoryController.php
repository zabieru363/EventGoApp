<?php
require_once(realpath(dirname(__FILE__)) . "../models/DAOCategories.php");
require_once(realpath(dirname(__FILE__)) . "../config/displayErrors.php");

final class CategoryController
{
    private $model;

    public function __construct()
    {
        $this->model = DAOCategories::getInstance();
    }

    /**
     * Método que devuelve en un array todas las categorias
     * del modelo que previamente se sacaron de la base de datos.
     * @return array Un array con todas las categorias.
     */
    public function listCategories():array
    {
        return $this->model->list();
    }
}