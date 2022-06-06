<?php
session_start();

mysqli_report(MYSQLI_REPORT_OFF);
//error_reporting(E_ERROR);

$host = "localhost";
$user = "root";
$psw = "";
$database = "productsdatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);


if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "EN";
}

$langs = ["EN", "PT"];

if (isset($_GET["lang"])) {
    if (!in_array($_GET["lang"], $langs)) {
        $_GET["lang"] = "EN";
    }

    $_SESSION["lang"] = $_GET["lang"];
}



if ($_SESSION["lang"] == "EN") {
    $otherlang = "PT";
    $togle = 0;
    $IDlang = 1;
} else {
    $otherlang = "EN";
    $togle = 5;
    $IDlang = 2;
}

if (!isset($_SESSION["userloggedIn"])) {
    $_SESSION["userloggedIn"] = false;
}
