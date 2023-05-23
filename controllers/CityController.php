<?php
require_once(realpath(dirname(__FILE__)) . "/../models/DAOCities.php");
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");

final class CityController
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