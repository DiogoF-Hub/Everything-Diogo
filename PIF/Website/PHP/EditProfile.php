<?php

require "commonCode.php";


if (isset($_POST["getProfileData"]) && $_SESSION["userloggedIn"] == true) {
    $Response = new stdClass();

    $sqlSelectUserData = $connection->prepare("SELECT * FROM Users WHERE email_id=?");
    $sqlSelectUserData->bind_param("s", $_SESSION["email"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();
    $row = $result->fetch_assoc();

    unset($row["user_id"]);
    unset($row["Userpassword"]);
    unset($row["Userpassword"]);
    unset($row["verified_email"]);
    unset($row["verified_email_code"]);

    $jsonArr = json_encode($row);
    $Response->$jsonArr;
    returnRes(data: $Response);
}


if (isset($_POST["firstNameProfile"], $_POST["lastNameProfile"], $_POST["emailProfile"], $_POST["PhoneNumberProfile"], $_POST["BadgeNumber"]) && $_SESSION["userloggedIn"] == true) {
    $firstNameSaveProfile = trim($_POST["firstNameProfile"]);
    $lastNameSaveProfile = trim($_POST["lastNameProfile"]);
    $emailSaveProfile = trim($_POST["emailProfile"]);
    $phoneSaveProfile = trim($_POST["PhoneNumberProfile"]);
    $badgeNumberSaveProfile = trim($_POST["BadgeNumber"]);

    $Response = new stdClass();

    $sqlSelectUserData = $connection->prepare("SELECT user_id FROM Users WHERE email_id=?");
    $sqlSelectUserData->bind_param("s", $_SESSION["email"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();
    $row = $result->fetch_assoc();

    if (!empty($firstNameSaveProfile) || !empty($lastNameSaveProfile) || !empty($emailSaveProfile) || !empty($phoneSaveProfile) || !empty($badgeNumberSaveProfile)) {

        if (!preg_match($namesRegex, $firstNameSaveProfile) || !preg_match($namesRegex, $lastNameSaveProfile)) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            if (strlen($firstNameSaveProfile) > 255 || strlen($lastNameSaveProfile) > 255) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }


        if (!preg_match($emailRegex, $emailSaveProfile)) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $sqlStatement = $connection->prepare("SELECT * from Users WHERE email_id=? AND user_id!=?");
            $sqlStatement->bind_param("ss", $emailSaveProfile, $row["user_id"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;

            if ($userexists > 0) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }

        if ($phoneSaveProfile != "-1") {
            if (!preg_match($phoneRegex, $phoneSaveProfile)) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }

        if ($badgeNumberSaveProfile != "-1") {
            $sqlStatement = $connection->prepare("SELECT * from Batches WHERE batch_number_id=?");
            $sqlStatement->bind_param("s", $badgeNumberSaveProfile);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $badgeexists = $result->num_rows;

            if ($badgeexists == 0) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }

            $sqlStatement2 = $connection->prepare("SELECT batch_number_id FROM Users WHERE batch_number_id=?");
            $sqlStatement2->bind_param("s", $badgeNumberSaveProfile);
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

        if ($row["email_id"] != $emailSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET email_id=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $emailSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
            $_SESSION["email"] = $emailSaveProfile;
        }

        if ($row["firstname"] != $firstNameSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET firstname=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $firstNameSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
            $_SESSION["firstname"] = $firstNameSaveProfile;
        }

        if ($row["lastname"] != $lastNameSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET lastname=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $lastNameSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
            $_SESSION["lastname"] = $lastNameSaveProfile;
        }

        if ($phoneSaveProfile != "-1") {
            if ($row["phoneNumber"] != $phoneSaveProfile) {
                $sqlUpdate = $connection->prepare("UPDATE Users SET phoneNumber=? WHERE user_id=?");
                $sqlUpdate->bind_param("ss", $phoneSaveProfile, $_SESSION["user_id"]);
                $sqlUpdate->execute();
            }
        } else {
            $A0 = 0;

            $sqlUpdate = $connection->prepare("UPDATE Users SET phoneNumber=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $A0, $_SESSION["user_id"]);
            $sqlUpdate->execute();
        }


        if ($badgeNumberSaveProfile != "-1" && $row["batch_number_id"] != $badgeNumberSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET batch_number_id=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $badgeNumberSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
        }

        $Response->Message = "1";
        returnRes(data: $Response);
    } else {
        $Response->Message = "1";
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
