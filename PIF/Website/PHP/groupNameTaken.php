<?php

require "commonCode.php";

//check if group name is taken
if (isset($_POST["groupNametaken"])) {
    $groupNameTaken = $connection->prepare("SELECT group_name from Groups_permissions WHERE group_name=?");
    $groupNameTaken->bind_param("s", $_POST["groupNametaken"]);
    $groupNameTaken->execute();
    $result = $groupNameTaken->get_result();
    $groupNameExist = $result->num_rows;

    $Response = new stdClass();

    if ($groupNameExist > 0) {
        $Response->Message = "1"; //taken
    } else {
        $Response->Message = "0"; //taken
    }
    returnRes(data: $Response);
}
