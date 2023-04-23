<?php

require "commonCode.php";


if (isset($_GET["hostname"], $_GET["rfid"])) {

    $HoursArr = [ //slots
        "8" => "1",
        "9" => "2",
        "10" => "3",
        "11" => "4",
        "12" => "5",
        "13" => "6",
        "14" => "7",
        "15" => "8",
        "16" => "9",
        "17" => "10"
    ];

    $HourNow = date("H"); //hour now
    $dateNow = date('Y-m-d'); //date now

    //what user tried to open
    $sqlUserKeyMatch = $connection->prepare("SELECT * FROM Users NATURAL JOIN Batches WHERE badge_key=?");
    $sqlUserKeyMatch->bind_param("s", $_GET["rfid"]);
    $sqlUserKeyMatch->execute();
    $result = $sqlUserKeyMatch->get_result();
    $UserExist = $result->num_rows;

    if ($UserExist == 1) {
        $row = $result->fetch_assoc();

        $userID = $row["user_id"];

        //Get room id by the number
        $sqlFindRoomID = $connection->prepare("SELECT room_id FROM Rooms WHERE number=?");
        $sqlFindRoomID->bind_param("s", $_GET["hostname"]);
        $sqlFindRoomID->execute();
        $result2 = $sqlFindRoomID->get_result();
        $roomExist = $result2->num_rows;

        if ($roomExist == 1) {
            $row2 = $result2->fetch_assoc();
            $RoomID = $row2["room_id"];
        } else {
            $data = array('allowed' => false);
            echo json_encode($data);
            die();
        }

        //check if a book exist
        $sqlCheckBooking = $connection->prepare("SELECT * FROM Booking_info WHERE booking_date=? AND user_id=? AND start_time<=? AND end_time>? AND room_id=?");
        $sqlCheckBooking->bind_param("siiii", $dateNow, $userID, $HoursArr[$HourNow], $HoursArr[$HourNow], $RoomID);
        $sqlCheckBooking->execute();
        $result2 = $sqlCheckBooking->get_result();
        $BookResults = $result2->num_rows;

        if ($BookResults == 1) {
            $data = array('allowed' => true); //open
        } else {
            $data = array('allowed' => false);
        }
    } else {
        $data = array('allowed' => false);
    }

    echo json_encode($data);
    die();
}
