<?php

require "commonCode.php";

//update profile info
if (isset($_POST["firstNameProfile"], $_POST["lastNameProfile"], $_POST["emailProfile"], $_POST["BadgeNumber"]) && $_SESSION["userloggedIn"] == true) {
    $firstNameSaveProfile = trim($_POST["firstNameProfile"]);
    $lastNameSaveProfile = trim($_POST["lastNameProfile"]);
    $emailSaveProfile = trim($_POST["emailProfile"]);
    $badgeNumberSaveProfile = trim($_POST["BadgeNumber"]);

    $Response = new stdClass();

    $sqlSelectUserData = $connection->prepare("SELECT user_id FROM Users WHERE email_id=?");
    $sqlSelectUserData->bind_param("s", $_SESSION["email"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();
    $row = $result->fetch_assoc();

    //validation
    if (!empty($firstNameSaveProfile) || !empty($lastNameSaveProfile) || !empty($emailSaveProfile) || !empty($badgeNumberSaveProfile)) {

        //validation
        if (!preg_match($namesRegex, $firstNameSaveProfile) || !preg_match($namesRegex, $lastNameSaveProfile)) {
            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            if (strlen($firstNameSaveProfile) > 255 || strlen($lastNameSaveProfile) > 255) {
                $Response->Message = "1";
                returnRes(data: $Response);
            }
        }

        //validation
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

        //validation
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


    $sqlStatement2 = $connection->prepare("SELECT * FROM Users WHERE user_id=?");
    $sqlStatement2->bind_param("s", $_SESSION["user_id"]);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();
    $userExist = $result2->num_rows;

    if ($userExist > 0) {
        $row = $result2->fetch_assoc();

        //update only if its different
        if ($row["email_id"] != $emailSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET email_id=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $emailSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
            $_SESSION["email"] = $emailSaveProfile;
        }

        //update only if its different
        if ($row["firstname"] != $firstNameSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET firstname=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $firstNameSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
            $_SESSION["firstname"] = $firstNameSaveProfile;
        }

        //update only if its different
        if ($row["lastname"] != $lastNameSaveProfile) {
            $sqlUpdate = $connection->prepare("UPDATE Users SET lastname=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $lastNameSaveProfile, $_SESSION["user_id"]);
            $sqlUpdate->execute();
            $_SESSION["lastname"] = $lastNameSaveProfile;
        }

        //update only if its different
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



//update psw
if (isset($_POST["currentPsw"], $_POST["newPsw"], $_POST["newPswRepeat"]) && $_SESSION["userloggedIn"] == true) {
    $Response = new stdClass();

    $sqlStatement2 = $connection->prepare("SELECT * FROM Users WHERE user_id=?");
    $sqlStatement2->bind_param("s", $_SESSION["user_id"]);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();
    $userExist = $result2->num_rows;

    //validation
    if ($userExist > 0) {
        $row = $result2->fetch_assoc();

        //validation
        if (strlen(trim($_POST["currentPsw"])) > 8 || strlen(trim($_POST["newPsw"])) > 8 || strlen(trim($_POST["newPswRepeat"])) > 8) {
            if (!password_verify(trim($_POST["newPsw"]), $row["Userpassword"])) {
                if (password_verify(trim($_POST["currentPsw"]), $row["Userpassword"])) {
                    $newPsw = trim($_POST["newPsw"]);
                    $hashPSW = password_hash($newPsw, PASSWORD_DEFAULT);

                    //hash and update
                    $sqlUpdate = $connection->prepare("UPDATE Users SET Userpassword=? WHERE user_id=?");
                    $sqlUpdate->bind_param("ss", $hashPSW, $_SESSION["user_id"]);
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

if (!empty($_FILES) && $_SESSION["userloggedIn"] == true) {
    $Response = new stdClass();

    $uploadErrors = array(
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"
    );

    $image = $_FILES["image"];

    if ($image["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $image["tmp_name"];
        $name = $image["name"];

        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png") {
            $Response->Message = "1";
            returnRes(data: $Response);
        }

        //Get the width and height of the image
        list($src_width, $src_height) = getimagesize($tmp_name);

        //Set the destination width and height
        $dst_width = 200;
        $dst_height = 200;

        //Calculate the aspect ratio of the source image and the destination image by dividing the width with the height
        $src_aspect_ratio = $src_width / $src_height;
        $dst_aspect_ratio = $dst_width / $dst_height;

        //Check if the aspect ratio of the source image is greater than or equal to the aspect ratio of the destination image
        if ($src_aspect_ratio >= $dst_aspect_ratio) { //This means that the original image is wider than the destination aspect ratio, so we need to crop horizontally
            //Calculate the source x and y coordinates and the source width
            $src_x = ($src_width - $src_height * $dst_aspect_ratio) / 2;
            $src_y = 0;
            $src_width = $src_height * $dst_aspect_ratio;
        } else { //this means the original image is taller than the destination aspect ratio, so we need to crop vertically
            //Calculate the source x and y coordinates and the source height
            $src_x = 0;
            $src_y = ($src_height - $src_width / $dst_aspect_ratio) / 2;
            $src_height = $src_width / $dst_aspect_ratio;
        }

        //Create a new true color image with the destination width and height
        $new_image = imagecreatetruecolor($dst_width, $dst_height);

        //Initialize the source image to null
        $src_image = null;

        //Check the extension of the image and create the source image accordingly
        if ($extension == "jpg" || $extension == "jpeg") {
            $src_image = imagecreatefromjpeg($tmp_name);
        } else if ($extension == "png") {
            $src_image = imagecreatefrompng($tmp_name);
        }

        //Copy and resize the source image to the new image
        imagecopyresampled($new_image, $src_image, 0, 0, $src_x, $src_y, $dst_width, $dst_height, $src_width, $src_height);



        $location = "../IMAGES/ProfilePics/" . $_SESSION["user_id"] . ".jpeg";
        if (imagejpeg($new_image, $location, 100)) {
            $A1 = 1;
            $sqlUpdate = $connection->prepare("UPDATE Users SET ProfilePic=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $A1, $_SESSION["user_id"]);
            $sqlUpdate->execute();

            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $Response->Message = "Something went wrong while saving the picture";
            returnRes(data: $Response);
        }
    } else {
        $Response->Message = $uploadErrors[$image["error"]];
        returnRes(data: $Response);
    }
}
