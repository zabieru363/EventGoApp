<?php
require_once(realpath(dirname(__FILE__)) . "/../models/DAOCategories.php");
require_once(realpath(dirname(__FILE__)) . "/../config/displayErrors.php");

final class CategoryController
{
    private $model;

    public function __construct()
    {
        $this->model = DAOCategories::getInstance();
    }

    /**
     * Método que llama al modelo para crear una categoría.
     * @param Category Un objeto Category para crear la categoría.
     * @return Category Un objeto Category con todos los datos ya
     * establecidos.
     */
    public function createCategory(Category $category)
    {
        return $this->model->create($category);
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

    /**
     * Método que llama al modelo para borrar una categoría.
     * @param int El id de la categoría que se quiere eliminar.
     * @return bool True si se ha eliminado, false si no es así.
     */
    public function deleteCategory(int $id):bool
    {
        return $this->model->delete($id);
    }

    /**
     * Métood que llama al modelo para comprobar si una categoría existe o no
     * @param string El nombre de la categoría.
     * @return bool True si existe, false si no es así.
     */
    public function categoryExists(string $category_name):bool
    {
        return $this->model->categoryExists($category_name);
    }
}