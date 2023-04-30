<?php
require "commonCode.php";

//sign up submission
if (isset($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["passwordRepeat"], $_POST["BadgeNumber"])) {

    $firstNameSignUp = trim($_POST["firstName"]);
    $lastNameSignUp = trim($_POST["lastName"]);
    $emailSignUp = trim($_POST["email"]);
    $passwordSignUp = trim($_POST["password"]);
    $passwordRepeatSignUp = trim($_POST["passwordRepeat"]);
    $badgeNumberSignUp = trim($_POST["BadgeNumber"]);

    $Response = new stdClass();

    //validation
    if (!empty($firstNameSignUp) && !empty($lastNameSignUp) && !empty($emailSignUp) && !empty($passwordSignUp) && !empty($passwordRepeatSignUp) && !empty($badgeNumberSignUp)) {

        if (!preg_match($namesRegex, $firstNameSignUp) || !preg_match($namesRegex, $lastNameSignUp)) {
            $Response->Message = "1";
            returnRes(data: $Response);
        }

        if (!preg_match($emailRegex, $emailSignUp)) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=?");
            $sqlStatement->bind_param("s", $emailSignUp);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;

            if ($userexists > 0) {
                $Response->Message = "The email is already taken";
                returnRes(data: $Response);
            }
        }

        if ($passwordSignUp !== $passwordRepeatSignUp) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            if (strlen($passwordSignUp) < 8) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }

        if ($badgeNumberSignUp == "-1") {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $sqlStatement2 = $connection->prepare("SELECT batch_number_id FROM Users WHERE batch_number_id=?");
            $sqlStatement2->bind_param("s", $badgeNumberSignUp);
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


    $hashPSW = password_hash($passwordSignUp, PASSWORD_DEFAULT);

    //insert new user
    $A0 = 0;
    $A1 = 1;
    $userIn = $connection->prepare("INSERT INTO Users (firstname, lastname, email_id, Userpassword, batch_number_id, group_id, ProfilePic) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $userIn->bind_param("ssssiii", $firstNameSignUp, $lastNameSignUp, $emailSignUp, $hashPSW, $badgeNumberSignUp, $A1, $A0);

    if ($userIn->execute()) {
        //creating session vals
        $sqlStatement = $connection->prepare("SELECT user_id FROM Users WHERE email_id=?");
        $sqlStatement->bind_param("s", $emailSignUp);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        $row = $result->fetch_assoc();

        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["userloggedIn"] = true;
        $_SESSION["firstname"] = $firstNameSignUp;
        $_SESSION["lastname"] = $lastNameSignUp;
        $_SESSION["email"] = $emailSignUp;
        $_SESSION["group_id"] = 1;

        $Response->Message = "1";
        returnRes(data: $Response);
    } else {
        $Response->Message = "SQL error";
        returnRes(data: $Response);
    }
}




//sign in submission
if (isset($_POST["emailin"], $_POST["passwordin"])) {

    $Response = new stdClass();

    //validation
    if (!empty($_POST["emailin"]) && !empty($_POST["passwordin"])) {

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

            if ($userexists == 0) {
                $Response->Message = "The user does not exist in the database";
                returnRes(data: $Response);
            } else {
                $row = $result->fetch_assoc();

                if (password_verify(trim($_POST["passwordin"]), $row["Userpassword"])) {
                    //creating session vals
                    $_SESSION["userloggedIn"] = true;
                    $_SESSION["user_id"] = $row["user_id"];
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
