<?php
session_start(); // start a session

$host = "localhost";
$user = "root";

// INSERT IT INTO THE DATABASE
$connection = new mysqli($host, $user, "", "Chat");


// this will be interacting with the JS program and will provide SERVER answers...

// USER LOGIN:

if (isset($_POST["UserName"])) { // when the user is LOGGIN IN - he prodived a UserName
    // I have received a username... what to do with it...

    $_SESSION["Login"] = $_POST["UserName"]; // MARK IN THE SESSION !!!
    // CHECK FIRST if the user exists
    $sqlSelect = $connection->prepare("Select * from Users where UserName=?");
    $sqlSelect->bind_param("s", $_POST["UserName"]);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    if ($result->num_rows == 0) {
        $sqlInsert = $connection->prepare("INSERT INTO Users(UserName) VALUES(?)"); // insert sql
        $sqlInsert->bind_param("s", $_POST["UserName"]); // bind the data from the user
        $sqlInsert->execute(); // run

    }
    print($_SESSION["Login"]);
}

if (isset($_POST["isUserLoggedIn"])) {
    if (isset($_SESSION["Login"])) {
        // print($_SESSION["Login"]);
        $response = ["UserLoggedIn" => true, "UserName" => $_SESSION["Login"]];
    } else {
        $response = ["UserLoggedIn" => false];
    }

    print(json_encode($response));
}

if (isset($_POST["newMessage"])) {
    //print("Writing message to db");
    $sqlNewMsgInsert = $connection->prepare("INSERT INTO messages(UserId,MsgText) VALUES((SELECT UserId from users where UserName=?),?) ");
    $sqlNewMsgInsert->bind_param("ss", $_SESSION["Login"], $_POST["newMessage"]);
    $sqlNewMsgInsert->execute();
}

if (isset($_POST["getMessagesFrom"])) {

    $sqlSelect = $connection->prepare("SELECT * from Messages natural join Users WHERE MsgId>?");
    $sqlSelect->bind_param("i", $_POST["getMessagesFrom"]);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    $arr = [];
    while ($row = $result->fetch_assoc()) {
        //print($row["UserName"] . " has wrote " . $row["MsgText"]);
        array_push($arr, $row);
    }
    print(json_encode($arr));
}


if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    die();
}
