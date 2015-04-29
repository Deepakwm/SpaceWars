<?php

    if(isset($_SERVER['APPLICATION_ENVIRONMENT'])){
        $env = $_SERVER['APPLICATION_ENVIRONMENT'];
    } else {
        $env = 'production';
    }

include_once $env.'/psl-config.php';   // As functions.php is not included
$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);