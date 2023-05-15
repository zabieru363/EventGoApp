<?php
final class Category
{
    private int $id;
    private string $name;

    public function __construct() {}

    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }
}