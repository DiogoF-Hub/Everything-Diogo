<?php

session_start();

if (!isset($_SESSION["userloggedIn"])) {
    $_SESSION["userloggedIn"] = false;
}

$host = "localhost";
$user = "root";
$psw = "";
$database = "PIFDatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

mysqli_report(MYSQLI_REPORT_OFF);
