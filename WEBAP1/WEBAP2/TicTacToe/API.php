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


if (isset($_POST["usernameTaken"])) {
    $Response = new stdClass();

    $usernameTaken = $connection->prepare("SELECT * from Users WHERE userName=?");
    $usernameTaken->bind_param("s", $_POST["usernameTaken"]);
    $usernameTaken->execute();
    $result = $usernameTaken->get_result();
    $usernameExist = $result->num_rows;


    if ($usernameExist > 0) {
        $Response->Message = true; //taken
    } else {
        $Response->Message = false; //not taken
    }
    echo json_encode($Response);
}



if (isset($_POST["emailTaken"])) {
    $Response = new stdClass();

    $emailTaken = $connection->prepare("SELECT * from Users WHERE email_id=?");
    $emailTaken->bind_param("s", $_POST["emailTaken"]);
    $emailTaken->execute();
    $result = $emailTaken->get_result();
    $emailExist = $result->num_rows;


    if ($emailExist > 0) {
        $Response->Message = true; //taken
    } else {
        $Response->Message = false; //not taken
    }
    echo json_encode($Response);
}
