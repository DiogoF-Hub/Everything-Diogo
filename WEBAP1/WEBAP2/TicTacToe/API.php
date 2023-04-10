<?php

session_start();

//database connection
$host = "localhost";
$user = "root";
$psw = "";
$database = "TicTacToeDatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

if (!isset($_SESSION["UserLoggedIn"])) {
    $_SESSION["UserLoggedIn"] = false;
}


if (isset($_POST["CheckUserLoggedIn"])) {
    $Response = new stdClass();

    $Response->Message = $_SESSION["UserLoggedIn"];
    echo json_encode($Response);
}
