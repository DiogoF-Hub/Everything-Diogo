<?php
require "commonCode.php";


if (isset($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["passwordRepeat"], $_POST["BadgeNumber"])) {

    $Response = new stdClass();


    if (!empty($_POST["firstName"]) || !empty($_POST["lastName"]) || !empty($_POST["email"]) || !empty($_POST["password"]) || !empty($_POST["passwordRepeat"]) || !empty($_POST["BadgeNumber"])) {

        if (!preg_match($namesRegex, $_POST["firstName"]) || !preg_match($namesRegex, $_POST["lastName"])) {
            $Response->Message = "1";
            returnRes(data: $Response);
        }

        if (!preg_match($emailRegex, $_POST["email"])) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=?");
            $sqlStatement->bind_param("s", $_POST["email"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;

            if ($userexists > 0) {
                $Response->Message = "The email is already taken";
                returnRes(data: $Response);
            }
        }

        if (trim($_POST["password"]) !== trim($_POST["passwordRepeat"])) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            if (strlen(trim($_POST["password"])) < 8) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }

        if ($_POST["BadgeNumber"] == "-1") {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $sqlStatement2 = $connection->prepare("SELECT batch_number_id FROM Users WHERE batch_number_id=?");
            $sqlStatement2->bind_param("s", $_POST["BadgeNumber"]);
            $sqlStatement2->execute();
            $result2 = $sqlStatement2->get_result();
            $badgeNumberTaken = $result2->num_rows;

            if ($badgeNumberTaken > 0) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }
    } else {
        $Response->Message = "1";
        returnRes(data: $Response);
    }

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $pswSignup = trim($_POST["password"]);
    $hashPSW = password_hash($pswSignup, PASSWORD_DEFAULT);


    $A0 = 0;
    $A1 = 1;
    $userIn = $connection->prepare("INSERT INTO Users (firstname, lastname, email_id, Userpassword, batch_number_id, group_id, verified_email, verified_email_code, phoneNumber, profilePic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $userIn->bind_param("ssssiiisis", trim($_POST["firstName"]), trim($_POST["lastName"]), $_POST["email"], $hashPSW, $_POST["BadgeNumber"], $A1, $A0, $randomString, $A0, $A0);

    if ($userIn->execute()) {
        $_SESSION["userloggedIn"] = true;
        $_SESSION["firstname"] = $_POST["firstName"];
        $_SESSION["lastname"] = $_POST["lastName"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["group_id"] = 1;

        $Response->Message = "1";
        returnRes(data: $Response);
    } else {
        $Response->Message = "SQL error";
        returnRes(data: $Response);
    }


    //email

}





if (isset($_POST["emailin"], $_POST["passwordin"])) {

    $Response = new stdClass();

    if (!empty($_POST["emailin"]) || !empty($_POST["passwordin"])) {

        if (strlen(trim($_POST["passwordin"])) < 8) {
            $Response->Message = "1";
            returnRes(data: $Response);
        }

        if (!preg_match($emailRegex, $_POST["emailin"])) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=?");
            $sqlStatement->bind_param("s", $_POST["emailin"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;

            if ($userexists < 0) {
                $Response->Message = "The user does not exist in the database";
                returnRes(data: $Response);
            } else {
                $row = $result->fetch_assoc();

                if (password_verify(trim($_POST["passwordin"]), $row["Userpassword"])) {
                    $_SESSION["userloggedIn"] = true;
                    $_SESSION["firstname"] = $row["firstname"];
                    $_SESSION["lastname"] = $row["lastname"];
                    $_SESSION["email"] = $row["email_id"];
                    $_SESSION["group_id"] = $row["group_id"];

                    $Response->Message = "1";
                    returnRes(data: $Response);
                } else {
                    $Response->Message = "Password does not match";
                    returnRes(data: $Response);
                }
            }
        }
    } else {
        $Response->Message = "1";
        returnRes(data: $Response);
    }
}
