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

    //Possible upload errors associative array
    $uploadErrors = array(
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"
    );


    $fileSize = $_FILES["image"]["size"];
    if ($fileSize > 10485760) {
        // File size is larger than 10MB
        $Response->Message = "1";
        returnRes(data: $Response);
    }


    $image = $_FILES["image"];

    if ($image["error"] == UPLOAD_ERR_OK) { //If the upload was successful
        $tmp_name = $image["tmp_name"];
        $name = $image["name"];

        //Get the extension in lower characters
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png") { //If the extension is not jpeg, jpg or png stop here
            $Response->Message = "1";
            returnRes(data: $Response);
        }

        //Get the width and height of the image
        list($src_width, $src_height) = getimagesize($tmp_name);


        if (!extension_loaded('gd')) {
            //GD extension is not enabled
            $Response->Message = "GD extension is not enabled on the server.";
            returnRes(data: $Response);
        }

        //Create a new true color image with the destination width and height using gd ext
        $new_image = imagecreatetruecolor(400, 400);

        //Initialize the source image to null
        $src_image = null;

        //Check the extension of the image and create the source image accordingly
        if ($extension == "jpg" || $extension == "jpeg") {
            $src_image = imagecreatefromjpeg($tmp_name);
        } else if ($extension == "png") {
            $src_image = imagecreatefrompng($tmp_name);
        }

        // Rotate the image based on the exif data
        if ($src_image !== null && function_exists('exif_read_data')) {
            if ($extension == "jpg" || $extension == "jpeg") { //PNG files does not support exif metadata
                $exif = exif_read_data($tmp_name); //Read the exif metadata of the file
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $src_image = imagerotate($src_image, 180, 0); //Rotates 180° so no need to change the width and height
                            break;
                        case 6:
                            $src_image = imagerotate($src_image, -90, 0);
                            list($src_width, $src_height) = array($src_height, $src_width); // swap width and height
                            break;
                        case 8:                                                             //The height becomes the width and the width becomes the height
                            $src_image = imagerotate($src_image, 90, 0);
                            list($src_width, $src_height) = array($src_height, $src_width); // swap width and height
                            break;
                    }
                }
            }
        } else {
            //Exif extension is not enabled
            $Response->Message = "The function exif_read_data does not exist, which means that the exif extension is not enabled on the server";
            returnRes(data: $Response);
        }

        //Set the destination width and height
        $dst_width = 400;
        $dst_height = 400;

        //Calculate the aspect ratio of the source image and the destination image by dividing the width with the height
        //This gives us two aspect ratios that we can use to compare the aspect ratios of the two images.
        $src_aspect_ratio = $src_width / $src_height;
        $dst_aspect_ratio = $dst_width / $dst_height;

        //Initialize the x and y coordinates of the cropped region and the width and height of the cropped image
        $src_x = 0;
        $src_y = 0;
        $crop_width = $src_width;
        $crop_height = $src_height;

        //Check if the aspect ratio of the source image is greater than or equal to the aspect ratio of the destination image
        if ($src_aspect_ratio >= $dst_aspect_ratio) {
            //The source image is wider than the destination image

            //We calculate the new width of the cropped region by multiplying the height of the image by the aspect ratio of the destination image
            $crop_width = $src_height * $dst_aspect_ratio;

            //We then set the x-coordinate of the cropped region to be the center of the original image minus half of the new cropped width.
            $src_x = ($src_width - $crop_width) / 2;
        } else {
            //The source image is taller than the destination image

            //We calculate the new height of the cropped region by dividing the width of the image by the aspect ratio of the destination image.
            $crop_height = $src_width / $dst_aspect_ratio;

            //We then set the y-coordinate of the cropped region to be the center of the original image minus half of the new cropped height.
            $src_y = ($src_height - $crop_height) / 2;
        }

        //We use the imagecopyresampled() function to copy and resize the image to fit into the 400 x 400 pixel square, using the coordinates and dimensions we calculated in the previous steps.
        imagecopyresampled($new_image, $src_image, 0, 0, $src_x, $src_y, $dst_width, $dst_height, $crop_width, $crop_height);


        //Save the image with the userID as the name
        $location = "../IMAGES/ProfilePics/" . $_SESSION["user_id"] . ".jpeg";
        if (imagejpeg($new_image, $location, 100)) { //Create jpeg file into a certain location with 100% quality

            //Update the profilePic field of the user in the database to 1
            $A1 = 1;
            $sqlUpdate = $connection->prepare("UPDATE Users SET ProfilePic=? WHERE user_id=?");
            $sqlUpdate->bind_param("ss", $A1, $_SESSION["user_id"]);
            $sqlUpdate->execute();

            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            //Something went wrong while saving the image
            $Response->Message = "Something went wrong while saving the image";
            returnRes(data: $Response);
        }
    } else {
        //If the upload was not successful, we return the error to the user.
        $Response->Message = $uploadErrors[$image["error"]];
        returnRes(data: $Response);
    }
}


if (isset($_POST["RemoveUserPic"]) && $_SESSION["userloggedIn"] == true) {
    $Response = new stdClass();

    //File location with name
    $File = "../IMAGES/ProfilePics/" . $_SESSION["user_id"] . ".jpeg";

    if (file_exists($File)) { //If the file exist
        unlink($File); //Delete the file

        //Update the profilePic field of the user in the database to 0
        $A0 = 0;
        $sqlUpdate = $connection->prepare("UPDATE Users SET ProfilePic=? WHERE user_id=?");
        $sqlUpdate->bind_param("ss", $A0, $_SESSION["user_id"]);
        $sqlUpdate->execute();

        $Response->Message = "1";
        returnRes(data: $Response);
    } else {
        //The file does not exist
        $Response->Message = "The File does not exist";
        returnRes(data: $Response);
    }
}
