<?php
/**
 * Created by PhpStorm.
 * User: m0pfin
 * Date: 03.03.2020
 * Time: 18:37
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$db = mysqli_connect("localhost", "db_fb", "password", "db_fb");

/* проверка подключения */
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}

