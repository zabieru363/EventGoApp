<?php
require_once("../lib/BaseController.php");
require_once("../config/displayErrors.php");
require_once("../models/DAOCities.php");

final class CityController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = DAOCities::getInstance();
    }

    /**
     * Método que devuelve en un array todas las ciudades
     * del modelo que previamente se sacaron de la base de datos.
     * @return array Un array con todas las ciudades.
     */
    public function listCities():array
    {
        return $this->model->list();
    }
}