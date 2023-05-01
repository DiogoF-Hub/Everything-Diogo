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
$userNameRegex = "/^[A-Za-z0-9_-]+$/";


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

    if (!empty($_POST["emailUsernameIn"]) && !empty($_POST["passwordIn"])) {

        if (strlen(trim($_POST["passwordIn"])) < 6) {
            $Response->Message = false;
            echo json_encode($Response);
            die();
        }


        if (!preg_match($emailRegex, $_POST["emailUsernameIn"])) {

            //If its not an email, it must be an username, so if does not match with the username regex something is wrong
            if (!preg_match($userNameRegex, $_POST["emailUsernameIn"])) {
                $Response->Message = false;
                echo json_encode($Response);
                die();
            }

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
    die();
}




if (isset($_POST["firstNameInputUp"], $_POST["lastNameInputUp"], $_POST["usernameInputUp"], $_POST["emailInputUp"], $_POST["passwordInputUp"], $_POST["passwordRepeatInputUp"])) {
    $Response = new stdClass();

    if (!empty($_POST["firstNameInputUp"]) && !empty($_POST["lastNameInputUp"]) && !empty($_POST["usernameInputUp"]) && !empty($_POST["emailInputUp"]) && !empty($_POST["passwordInputUp"]) && !empty($_POST["passwordRepeatInputUp"])) {

        if (strlen(trim($_POST["firstNameInputUp"])) > 25 || strlen(trim($_POST["firstNameInputUp"])) < 1 || strlen(trim($_POST["lastNameInputUp"])) > 25 || strlen(trim($_POST["lastNameInputUp"])) < 1 || !preg_match($namesRegex, $_POST["firstNameInputUp"]) || !preg_match($namesRegex, $_POST["lastNameInputUp"])) {
            $Response->Message = false;
            echo json_encode($Response);
            die();
        }



        if (strlen(trim($_POST["usernameInputUp"])) < 3 || strlen(trim($_POST["usernameInputUp"])) > 15 || !preg_match($userNameRegex, $_POST["usernameInputUp"])) {
            $Response->Message = false;
            echo json_encode($Response);
            die();
        }



        if (strlen(trim($_POST["emailInputUp"])) > 320 || !preg_match($emailRegex, $_POST["emailInputUp"])) {
            $Response->Message = false;
            echo json_encode($Response);
            die();
        }



        if (trim($_POST["passwordInputUp"]) !== trim($_POST["passwordRepeatInputUp"]) || strlen(trim($_POST["passwordInputUp"])) < 6 || strlen(trim($_POST["passwordRepeatInputUp"])) < 6) {
            $Response->Message = false;
            echo json_encode($Response);
            die();
        }



        $hashPSW = password_hash(trim($_POST["passwordInputUp"]), PASSWORD_DEFAULT);


        $sqlInsertUser = $connection->prepare("INSERT INTO Users (userName, email_id, firstname, lastname, userpassword) VALUES (?, ?, ?, ?, ?)");
        $sqlInsertUser->bind_param("sssss", $_POST["usernameInputUp"], $_POST["emailInputUp"], $_POST["firstNameInputUp"], $_POST["lastNameInputUp"], $hashPSW);

        if ($sqlInsertUser->execute()) {
            $_SESSION["UserLoggedIn"] = true;
            $_SESSION["UserName"] = $_POST["usernameInputUp"];
            $_SESSION["email"] = $_POST["emailInputUp"];
            $_SESSION["firstname"] = $_POST["firstNameInputUp"];
            $_SESSION["lastname"] = $_POST["lastNameInputUp"];

            $Response->Message = true;
        } else {
            $Response->Message = "Something went wrong while inserting the user";
        }
    } else {
        $Response->Message = false;
    }

    echo json_encode($Response);
    die();
}



if (isset($_POST["logout"])) {
    $Response = new stdClass();

    session_destroy(); //This destroys the session
    $_SESSION = array(); //This clears the session array

    $_SESSION["UserLoggedIn"] = false;

    $Response->Message = true;

    echo json_encode($Response);
    die();
}



if (isset($_POST["getavailableGames"])) {
    $data = array();

    $A0 = 0;
    $A1 = 1;

    $sqlgetavailableGames = $connection->prepare("SELECT GameID, FirstPlayerID FROM Games WHERE GameStatus=? AND SecondPlayerID=?");
    $sqlgetavailableGames->bind_param("ii", $A1, $A0);
    $sqlgetavailableGames->execute();
    $result = $sqlgetavailableGames->get_result();

    while ($row = $result->fetch_assoc()) {
        $sqlGetUserDataGame = $connection->prepare("SELECT userName FROM Users WHERE UserID=?");
        $sqlGetUserDataGame->bind_param("i", $row["FirstPlayerID"]);
        $sqlGetUserDataGame->execute();
        $result2 = $sqlGetUserDataGame->get_result();
        $row2 = $result2->fetch_assoc();

        $data[$row["GameID"]] = $row2["userName"];
    }

    echo json_encode($data);
    die();
}




if (isset($_POST["createGame"])) {
}
