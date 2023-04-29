<?php

session_start();

//database connection
$host = "localhost";
$user = "root";
$psw = "";
$database = "TicTacToe";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);


$namesRegex = "/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ''\-]+$/";
$emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";


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



if (isset($_POST["emailUsernameIn"], $_POST["passwordIn"])) {
    $Response = new stdClass();

    if (!empty($_POST["emailUsernameIn"]) || !empty($_POST["passwordIn"])) {

        if (strlen(trim($_POST["passwordIn"])) < 6) {
            $Response->Message = false;
            echo json_encode($Response);
            die();
        }

        if (!preg_match($emailRegex, $_POST["emailUsernameIn"])) {
            $sqlFindUser = $connection->prepare("SELECT * from Users WHERE userName=?");
            $sqlFindUser->bind_param("s", $_POST["emailUsernameIn"]);
            $sqlFindUser->execute();
            $result = $sqlFindUser->get_result();
            $userExist = $result->num_rows;
        } else {
            $sqlFindUser = $connection->prepare("SELECT * from Users WHERE email_id=?");
            $sqlFindUser->bind_param("s", $_POST["emailUsernameIn"]);
            $sqlFindUser->execute();
            $result = $sqlFindUser->get_result();
            $userExist = $result->num_rows;
        }


        if ($userExist == 1) {
            $row = $result->fetch_assoc();

            if (password_verify(trim($_POST["passwordIn"]), $row["userpassword"])) {

                $_SESSION["UserLoggedIn"] = true;
                $_SESSION["UserName"] = $row["userName"];
                $_SESSION["email"] = $row["email_id"];
                $_SESSION["firstname"] = $row["firstname"];
                $_SESSION["lastname"] = $row["lastname"];

                $Response->Message = true;
            } else {
                $Response->Message = "Password does not match";
            }
        } else {
            $Response->Message = "User does not exist";
        }
    } else {
        $Response->Message = false;
    }



    echo json_encode($Response);
}
