<?php

require "commonCode.php";


if (isset($_POST["getProfileData"]) && $_SESSION["userloggedIn"] == true) {
    $sqlSelectUserData = $connection->prepare("SELECT * FROM Users WHERE email_id=?");
    $sqlSelectUserData->bind_param("s", $_SESSION["email"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();
    $row = $result->fetch_assoc();

    unset($row['Userpassword']);
    unset($row['Userpassword']);
    unset($row["verified_email"]);
    unset($row["verified_email_code"]);


    $Response->json_encode($arr);
    returnRes(data: $Response);
}


if (isset($_POST["firstNameProfile"], $_POST["lastNameProfile"], /*$_POST["emailProfile"],*/ $_POST["PhoneNumberProfile"], $_POST["BadgeNumber"]) && $_SESSION["userloggedIn"] == true) {
    $Response = new stdClass();

    if (!empty($_POST["firstNameProfile"]) || !empty($_POST["lastNameProfile"]) || !empty($_POST["emailProfile"]) || !empty($_POST["PhoneNumberProfile"]) || !empty($_POST["BadgeNumber"])) {

        if (!preg_match($namesRegex, $_POST["firstNameProfile"]) || !preg_match($namesRegex, $_POST["lastNameProfile"])) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            if (strlen($_POST["firstNameProfile"]) > 255 || strlen($_POST["lastNameProfile"]) > 255) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }


        // if (!preg_match($emailRegex, $_POST["emailProfile"])) {
        //     $Response->Message = "Email regex";
        //     returnRes(data: $Response);
        // } else {
        //     $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=?");
        //     $sqlStatement->bind_param("s", $_POST["emailProfile"]);
        //     $sqlStatement->execute();
        //     $result = $sqlStatement->get_result();
        //     $userexists = $result->num_rows;

        //     if ($userexists > 0) {
        //         $Response->Message = "The email is already taken";
        //         returnRes(data: $Response);
        //     }
        // }

        if ($_POST["PhoneNumberProfile"] != "-1") {
            if (!preg_match($phoneRegex, $_POST["PhoneNumberProfile"])) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }

        if ($_POST["BadgeNumber"] != "-1") {
            $sqlStatement = $connection->prepare("SELECT * from Batches WHERE batch_number_id=?");
            $sqlStatement->bind_param("s", $_POST["BadgeNumber"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $badgeexists = $result->num_rows;

            if ($badgeexists == 0) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }

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


    $sqlStatement2 = $connection->prepare("SELECT * FROM Users WHERE email_id=?");
    $sqlStatement2->bind_param("s", $_SESSION["email"]);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();
    $userExist = $result2->num_rows;

    if ($userExist > 0) {
        $row = $result2->fetch_assoc();

        if ($row["firstname"] != $_POST["firstNameProfile"]) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET firstname=? WHERE email_id=?");
            $sqlUpdate->bind_param("ss", $_POST["firstNameProfile"], $_SESSION["email"]);
            $sqlUpdate->execute();
            $_SESSION["firstname"] = $_POST["firstNameProfile"];
        }

        if ($row["lastname"] != $_POST["lastNameProfile"]) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET lastname=? WHERE email_id=?");
            $sqlUpdate->bind_param("ss", $_POST["lastNameProfile"], $_SESSION["email"]);
            $sqlUpdate->execute();
            $_SESSION["lastname"] = $_POST["lastNameProfile"];
        }

        if ($_POST["PhoneNumberProfile"] != "-1") {
            if ($row["phoneNumber"] != $_POST["PhoneNumberProfile"]) {
                $sqlUpdate = $connection->prepare("UPDATE Users SET phoneNumber=? WHERE email_id=?");
                $sqlUpdate->bind_param("ss", $_POST["PhoneNumberProfile"], $_SESSION["email"]);
                $sqlUpdate->execute();
            }
        } else {
            $A0 = 0;

            $sqlUpdate = $connection->prepare("UPDATE Users SET phoneNumber=? WHERE email_id=?");
            $sqlUpdate->bind_param("ss", $A0, $_SESSION["email"]);
            $sqlUpdate->execute();
        }


        if ($_POST["BadgeNumber"] != "-1" && $row["batch_number_id"] != $_POST["BadgeNumber"]) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET batch_number_id=? WHERE email_id=?");
            $sqlUpdate->bind_param("ss", $_POST["BadgeNumber"], $_SESSION["email"]);
            $sqlUpdate->execute();
        }

        $Response->Message = "Profile saved";
        returnRes(data: $Response);
    } else {
        $Response->Message = "Users does not exist";
        returnRes(data: $Response);
    }
}




if (isset($_POST["currentPsw"], $_POST["newPsw"], $_POST["newPswRepeat"]) && $_SESSION["userloggedIn"] == true) {
    $Response = new stdClass();

    $sqlStatement2 = $connection->prepare("SELECT * FROM Users WHERE email_id=?");
    $sqlStatement2->bind_param("s", $_SESSION["email"]);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();
    $userExist = $result2->num_rows;

    if ($userExist > 0) {
        $row = $result2->fetch_assoc();


        if (strlen(trim($_POST["currentPsw"])) > 8 || strlen(trim($_POST["newPsw"])) > 8 || strlen(trim($_POST["newPswRepeat"])) > 8) {
            if (!password_verify(trim($_POST["newPsw"]), $row["Userpassword"])) {
                if (password_verify(trim($_POST["currentPsw"]), $row["Userpassword"])) {
                    $newPsw = trim($_POST["newPsw"]);
                    $hashPSW = password_hash($newPsw, PASSWORD_DEFAULT);

                    $sqlUpdate = $connection->prepare("UPDATE Users SET Userpassword=? WHERE email_id=?");
                    $sqlUpdate->bind_param("ss", $hashPSW, $_SESSION["email"]);
                    $sqlUpdate->execute();

                    $Response->Message = "1";
                    returnRes(data: $Response);
                } else {
                    $Response->Message = "The current password dont match";
                    returnRes(data: $Response);
                }
            } else {
                $Response->Message = "The new password is the same as the current password";
                returnRes(data: $Response);
            }
        } else {
            $Response->Message = "1";
            returnRes(data: $Response);
        }
    } else {
        $Response->Message = "1";
        returnRes(data: $Response);
    }
}
