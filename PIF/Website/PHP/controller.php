<?php

require "commonCode.php";


if (isset($_POST["room_id"], $_POST["key"])) {
    $Response = new stdClass(); //create response

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
    $sqlUserKeyMatch->bind_param("s", $_POST["key"]);
    $sqlUserKeyMatch->execute();
    $result = $sqlUserKeyMatch->get_result();
    $UserExist = $result->num_rows;

    if ($UserExist == 1) {
        $row = $result->fetch_assoc();

        $userID = $row["user_id"];

        //check if a book exist
        $sqlCheckBooking = $connection->prepare("SELECT * FROM Booking_info WHERE booking_date=? AND user_id=? AND start_time<=? AND end_time>? AND room_id=?");
        $sqlCheckBooking->bind_param("siiii", $dateNow, $userID, $HoursArr[$HourNow], $HoursArr[$HourNow], $_POST["room_id"]);
        $sqlCheckBooking->execute();
        $result2 = $sqlCheckBooking->get_result();
        $BookResults = $result2->num_rows;

        if ($BookResults == 1) {
            $Response->Message = json_encode("accepted: true"); //open
            returnRes(data: $Response);
        } else {
            $Response->Message = json_encode("accepted: false");
            returnRes(data: $Response);
        }
    } else {
        $Response->Message = json_encode("accepted: false");
        returnRes(data: $Response);
    }
}
