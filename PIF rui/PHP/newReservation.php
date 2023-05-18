<?php
require("../HTML/CommonCode.php");



if (isset($_POST["dateSelected"], $_POST["startTime"], $_POST["endTime"])) {




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
