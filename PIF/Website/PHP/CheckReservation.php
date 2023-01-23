<?php

require "commonCode.php";

$roomsArr = [];


function rooms($dateVal, $startTime, $endTime) //func to filter rooms
{
    //global to work from outside the func
    global $connection;
    global $roomsArr;
    $occupiedRooms = [];
    $rangeTaken = range($startTime, $endTime + 1);


    $time = strtotime($dateVal);
    $newformat = date('Y-m-d', $time);

    $sqlStatement = $connection->prepare("SELECT * FROM Booking_info WHERE booking_date=?");
    $sqlStatement->bind_param("s", $newformat);
    $sqlStatement->execute();
    $result2 = $sqlStatement->get_result();

    while ($row2 = $result2->fetch_assoc()) {
        if (!in_array($row2["room_id"], $occupiedRooms)) {
            $rangeRow = range($row2["start_time"], $row2["end_time"]);
            for ($i = 0; $i < count($rangeRow); $i++) {
                if (in_array($rangeRow[$i], $rangeTaken) && !in_array($row2["room_id"], $occupiedRooms)) {
                    $occupiedRooms[] = $row2["room_id"]; //create arr with all occupiedRooms
                }
            }
        }
    }

    $sqlStatement = $connection->prepare("SELECT * FROM Rooms");
    $sqlStatement->execute();
    $result2 = $sqlStatement->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        if (in_array($row2["room_id"], $occupiedRooms)) {
            continue;
        }
        $room = new stdClass();
        $room->room_number = $row2["number"];
        $room->room_id = $row2["room_id"];
        $room->room_capacity = $row2["capacity"];
        $room->room_description = $row2["description"];
        array_push($roomsArr, $room); //push all available rooms
    }
}



//submit reser
if (isset($_POST["inputDate2"], $_POST["startTimeVal2"], $_POST["endTimeVal2"], $_POST["roomsIDSelect"], $_POST["purpose"]) && $_SESSION["userloggedIn"] == true && $_SESSION["group_right_schedule"] == 1) {
    $Response = new stdClass();

    $dateVal = $_POST["inputDate2"];
    $startTime = $_POST["startTimeVal2"];
    $endTime = intval($_POST["endTimeVal2"] + 1);
    $RoomID = $_POST["roomsIDSelect"];
    $purpose = $_POST["purpose"];

    //validation
    if (is_numeric($startTime) && is_numeric($endTime)) {
        if ($endTime >= $startTime) {
            if (validateDate($dateVal)) {

                rooms($dateVal, $startTime, $endTime);

                $toggle = false;
                for ($i = 0; $i < count($roomsArr); $i++) {
                    $roomm = $roomsArr[$i];
                    if ($roomm->room_id == $RoomID) {
                        $toggle = true;
                        break;
                    }
                }

                if ($toggle) {

                    $time = strtotime($dateVal);
                    $newformat = date('Y-m-d', $time);

                    //insert
                    $sqlInsert = $connection->prepare("INSERT INTO Booking_info (`room_id`, `user_id`, `booking_date`, `purpose`, `start_time`, `end_time`) VALUES(?, ?, ?, ?, ?, ?)");
                    $sqlInsert->bind_param("iissii", $RoomID, $_SESSION["user_id"], $newformat, $purpose, $startTime, $endTime);

                    if ($sqlInsert->execute()) {
                        $Response->Message = "1";
                        returnRes(data: $Response);
                    }
                } else {
                    $Response->Message = "2";
                    returnRes(data: $Response);
                }
            } else {
                $Response->Message = "2";
                returnRes(data: $Response);
            }
        } else {
            $Response->Message = "2";
            returnRes(data: $Response);
        }
    } else {
        $Response->Message = "2";
        returnRes(data: $Response);
    }
}






//filter available rooms
if (isset($_POST["inputDate"], $_POST["startTimeVal"], $_POST["endTimeVal"]) && $_SESSION["userloggedIn"] == true && $_SESSION["group_right_schedule"] == 1) {

    $Response = new stdClass();

    $dateVal = $_POST["inputDate"];
    $startTime = $_POST["startTimeVal"];
    $endTime = $_POST["endTimeVal"];

    //validation
    if (is_numeric($startTime) && is_numeric($endTime)) {
        if ($endTime >= $startTime) {
            if (validateDate($dateVal)) {

                rooms($dateVal, $startTime, $endTime); //call rooms func

                //return available rooms
                $Response->Rooms = $roomsArr;
                $Response->Message = "1";
                returnRes(data: $Response);
            } else {
                $Response->Message = "2";
                returnRes(data: $Response);
            }
        } else {
            $Response->Message = "2";
            returnRes(data: $Response);
        }
    } else {
        $Response->Message = "2";
        returnRes(data: $Response);
    }
}
