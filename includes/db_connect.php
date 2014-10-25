<?php
include_once 'psl-config.php';   // As functions.php is not included
$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);