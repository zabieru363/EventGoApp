<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $cookies_accepted = $_POST["cookies-accepted"];

    $seconds = 30 * 24 * 60 * 60;   // 30 dias en segundos
    $now = time();
    $expiration = $now + $seconds;

    setcookie('cookies-accepted', $token, $expiration, '/');
}