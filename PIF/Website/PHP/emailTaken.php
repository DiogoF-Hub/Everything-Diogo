<?php

require "commonCode.php";

//check if email is taken
if (isset($_POST["emailTaken"])) {
    $emailTaken = $connection->prepare("SELECT * from Users WHERE email_id=?");
    $emailTaken->bind_param("s", $_POST["emailTaken"]);
    $emailTaken->execute();
    $result = $emailTaken->get_result();
    $emailExist = $result->num_rows;

    $Response = new stdClass();

    if ($emailExist > 0) {
        $Response->Message = "1"; //taken
    } else {
        $Response->Message = "0"; //not taken
    }
    returnRes(data: $Response);
}
