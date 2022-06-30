<?php
session_start();

$host = "localhost";
$user = "root";
$psw = "";
$database = "productsdatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

//mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_POST["logoutbutton"])) {
    $chartArrayserialized = serialize($_SESSION["Chart"]);
    $sqlInsert3 = $connection->prepare("UPDATE Users SET Chart=? WHERE UserName=?");
    $sqlInsert3->bind_param("ss", $chartArrayserialized, $_SESSION["username"]);
    $sqlInsert3->execute();

    session_unset();
    session_destroy();
    header('Location: Home.php');
    die();
}


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
    $sqlLang = 1;
} else {
    $otherlang = "EN";
    $sqlLang = 2;
}


if (!isset($_SESSION["userloggedIn"])) {
    $_SESSION["userloggedIn"] = false;
}
