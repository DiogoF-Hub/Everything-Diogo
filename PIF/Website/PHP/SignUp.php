<?php
require "commmonCode.php";

$namesRegex = "/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ'`'\-]+$/";
$emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

if (isset($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["passwordRepeat"])) {

    $Response = new stdClass();


    if (!empty($_POST["firstName"]) || !empty($_POST["lastName"]) || !empty($_POST["email"]) || !empty($_POST["password"]) || !empty($_POST["passwordRepeat"])) {

        if (!preg_match($namesRegex, $_POST["firstName"]) || !preg_match($namesRegex, $_POST["lastName"])) {
            $Response->Message = "Name regex";
            //$type = "Forbidden";
            returnRes(data: $Response);
        }

        if (!preg_match($emailRegex, $_POST["email"])) {
            $Response->Message = "Email regex";
            //$type = "Forbidden";
            returnRes(data: $Response);
        } else {
            $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=?");
            $sqlStatement->bind_param("s", $_POST["email"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;

            if ($userexists < 1) {
                $Response->Message = "The email is already taken";
                //$type = "Forbidden";
                returnRes(data: $Response);
            }
        }

        if ($_POST["password"] !== $_POST["passwordRepeat"]) {
            $Response->Message = "Password is not the same";
            //$type = "Forbidden";
            returnRes(data: $Response);
        } else {
            if (strlen($_POST["password"]) < 8) {
                $Response->Message = "Password length is not 8";
                //$type = "Forbidden";
                returnRes(data: $Response);
            }
        }
    } else {
        $Response->Message = "Something empty";
        //$type = "Forbidden";
        returnRes(data: $Response);
    }

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }


    $pswSignup = $_POST["password"];
    $hashPSW = password_hash($pswSignup, PASSWORD_DEFAULT);


    $sqlInsert = $connection->prepare("INSERT INTO Users (firstname, lastname, email_id, Userpassword, batch_number_id, group_id, verified_email, verified_email_code) VALUES (?, ?, ?, ?, 1, 1, 0, ?)");
    $sqlInsert->bind_param("sssss", $_POST["firstName"], $_POST["lastName"], $_POST["email"], $hashPSW, $randomString);

    if ($sqlInsert->excute()) {
        $_SESSION["userloggedIn"] = true;
        $_SESSION["firstname"] = $_POST["firstName"];
        $_SESSION["lastname"] = $_POST["lastName"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["group_id"] = 1;
    } else {
        $Response->Message = "SQL error";
        //$type = "Success";

        returnRes(data: $Response);
    }


    //email


    $Response->Message = "User created";
    $type = "Success";

    returnRes(data: $Response);
}
