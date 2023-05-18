<?php
//This is to run when the page is fully loaded 
session_start();

// This checks if the user is logged in and if he is it displays a logout option and then the session is destroyed
if (!isset($_SESSION["UserLogged"])) {
    $_SESSION["UserLogged"] = false;
}

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: Login.php");
    die();
}
// end

// This connects to the database
$host = "localhost";
$user = "root";
$psw = "";
$database = "DatabasePIF";
$portNo = 3306;
$connection = new mysqli($host, $user, $psw, $database, $portNo);
// end
