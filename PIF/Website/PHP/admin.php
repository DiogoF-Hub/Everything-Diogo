<?php
require "commonCode.php";

if (isset($_POST["newgroup"], $_POST["userid"], $_SESSION["userloggedIn"]) && $_SESSION["userloggedIn"] == true && $_SESSION["group_id"] == 2) {
    $Response = new stdClass();
    if (is_numeric($_POST["newgroup"]) && is_numeric($_POST["userid"])) {

        if ($_POST["newgroup"] != 2) {
            $sqlStatement2 = $connection->prepare("SELECT * FROM Groups_permissions WHERE group_id=?");
            $sqlStatement2->bind_param("s", $_POST["newgroup"]);
            $sqlStatement2->execute();
            $result2 = $sqlStatement2->get_result();
            $groupExist = $result2->num_rows;

            if ($groupExist > 0) {
                $sqlStatement = $connection->prepare("SELECT group_id FROM Users WHERE user_id=?");
                $sqlStatement->bind_param("s", $_POST["userid"]);
                $sqlStatement->execute();
                $result = $sqlStatement->get_result();
                $userExist = $result->num_rows;

                if ($userExist > 0) {
                    $row = $result->fetch_assoc();

                    if ($row["group_id"] != $_POST["newgroup"]) {
                        $sqlUpdate = $connection->prepare("UPDATE Users SET group_id=? WHERE user_id=?");
                        $sqlUpdate->bind_param("ss", $_POST["newgroup"], $_POST["userid"]);
                        $sqlUpdate->execute();
                    }

                    $Response->Message = "2";
                    returnRes(data: $Response);
                } else {
                    $Response->Message = "1";
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
    } else {
        $Response->Message = "1";
        returnRes(data: $Response);
    }
}



if (isset($_POST["groupName"], $_POST["ScheduleSwitch"], $_POST["view_sensitive_dataSwitch"], $_POST["open_door_any_timeSwitch"], $_POST["open_door_when_its_availableSwitch"]) && $_SESSION["userloggedIn"] == true && $_SESSION["group_id"] == 2) {
    $Response = new stdClass();

    $ScheduleSwitch = 0;
    $view_sensitive_dataSwitch = 0;
    $open_door_any_timeSwitch = 0;
    $open_door_when_its_availableSwitch = 0;

    if (!empty($_POST["groupName"]) || !empty($_POST["ScheduleSwitch"]) || !empty($_POST["view_sensitive_dataSwitch"]) || !empty($_POST["open_door_any_timeSwitch"]) || !empty($_POST["open_door_when_its_availableSwitch"])) {

        $groupNameTaken = $connection->prepare("SELECT group_name from Groups_permissions WHERE group_name=?");
        $groupNameTaken->bind_param("s", $_POST["groupName"]);
        $groupNameTaken->execute();
        $result = $groupNameTaken->get_result();
        $groupNameExist = $result->num_rows;

        if ($groupNameExist == 0) {

            if ($_POST["ScheduleSwitch"] == true) {
                $ScheduleSwitch = 1;
            }

            if ($_POST["view_sensitive_dataSwitch"] == true) {
                $view_sensitive_dataSwitch = 1;
            }

            if ($_POST["open_door_any_timeSwitch"] == true) {
                $open_door_any_timeSwitch = 1;
            }

            if ($_POST["open_door_when_its_availableSwitch"] == true) {
                $open_door_when_its_availableSwitch = 1;
            }

            $A0 = 0;
            $userIn = $connection->prepare("INSERT INTO Groups_permissions (group_name, admin, schedule, view_sensitive_data, open_door_any_time, open_door_available) VALUES (?, ?, ?, ?, ?, ?)");
            $userIn->bind_param("siiiii", $_POST["groupName"], $A0, $ScheduleSwitch, $view_sensitive_dataSwitch, $open_door_any_timeSwitch, $open_door_when_its_availableSwitch);
            $userIn->execute();

            $Response->Message = "1";
            returnRes(data: $Response);
        } else {
            $Response->Message = "1";
            returnRes(data: $Response);
        }
    } else {
        $Response->Message = "1";
        returnRes(data: $Response);
    }
}
