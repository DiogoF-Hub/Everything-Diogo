<?php
require "commonCode.php";

if (isset($_POST["emailin"], $_POST["passwordin"])) {

    $Response = new stdClass();

    if (!empty($_POST["emailin"]) || !empty($_POST["passwordin"])) {

        if (strlen($_POST["passwordin"]) < 8) {
            $Response->Message = "Password length is not 8";
            returnRes(data: $Response);
        }

        if (!preg_match($emailRegex, $_POST["emailin"])) {
            $Response->Message = "Email regex";
            returnRes(data: $Response);
        } else {
            $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=?");
            $sqlStatement->bind_param("s", $_POST["emailin"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;

            if ($userexists < 0) {
                $Response->Message = "The email does not exist in the database";
                returnRes(data: $Response);
            } else {
                $row = $result->fetch_assoc();

                if (password_verify($_POST["passwordin"], $row["Userpassword"])) {
                    $_SESSION["userloggedIn"] = true;
                    $_SESSION["firstname"] = $row["firstname"];
                    $_SESSION["lastname"] = $row["lastname"];
                    $_SESSION["email"] = $row["email_id"];
                    $_SESSION["group_id"] = $row["group_id"];

                    $Response->Message = "Nice";
                    returnRes(data: $Response);
                } else {
                    $Response->Message = "Password does not match";
                    returnRes(data: $Response);
                }
            }
        }
    } else {
        $Response->Message = "Something empty";
        returnRes(data: $Response);
    }
}
