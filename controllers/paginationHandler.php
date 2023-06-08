<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $data = json_decode(file_get_contents('php://input'), true);

    $total_rows = $user_controller->getNumberTotalUsers();
    $page = $data["page"];

    $start = 0;

    if($page === 1) $start = 0;
    else $start = ($page - 1) * 10;
}