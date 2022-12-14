<?php

/* This is a script that will answer a question:

Is there a user (provided in the POST array - at index "User") in our database
that has the password (provided in the POST array - at an index "Psw") ????
*/


if (isset($_POST["User"], $_POST["Psw"])) {
    $host = "localhost";
    $user = "root";
    $psw = "";
    $database = "Users";
    $portNo = 3306;

    $connection = new mysqli($host, $user, $psw, $database, $portNo);

    $sqlSelect = $connection->prepare("SELECT * from Users where UserName=?");
    $sqlSelect->bind_param("s", $_POST["User"]);
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    if ($result->num_rows == 0) {
        print("We are sorry but there is not user " . $_POST["User"] . " in our db");
    } else {
        $row = $result->fetch_assoc();
        if ($row["UserPassword"] == $_POST["Psw"]) {
            print("Well done, you have logged in !!");
        } else {
            print("The password is incorrect");
        }
    }
} else {
    print("Badly formed QUESTION");
}
