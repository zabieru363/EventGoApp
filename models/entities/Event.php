<?php
final class Event
{
    private int $id;
    private string $title;
    private string $description;
    private string $admin;
    private int $location;
    private int $user_id;
    private string $start_date;
    private string $end_date;
    private bool $active;

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