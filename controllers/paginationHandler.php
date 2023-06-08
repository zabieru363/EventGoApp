<?php
require_once("UserController.php");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $user_controller = new UserController();
    $data = json_decode(file_get_contents('php://input'), true);

    $total_rows = $user_controller->getNumberTotalUsers();
    $page = $data["page"];

    $start = 0;
    $rows_per_page = 10;

    $total_pages = ceil($total_rows / $rows_per_page);

    if($page < 1) $page = 1;
    else $page = $total_pages;

    $start = ($page - 1) * $rows_per_page;

    $users = $user_controller->listUsers($start, $rows_per_page);
}