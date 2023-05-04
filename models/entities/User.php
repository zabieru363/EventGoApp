<?php
final class User
{
    private int $id;
    private string $username;
    private string $password;
    private string $type;
    private string $fullname;
    private string $email;
    private string $country;
    private string $city;
    private bool $active;
    private string $register_date;
    private string $image;

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