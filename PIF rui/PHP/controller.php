<?php

include_once("../HTML/CommonCode.php");


if (isset($_GET["hostname"], $_GET["rfid"])) {

    $SlotsHours = [ //slots
        "08" => "1",
        "09" => "2",
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
    $sqlUserInfoFromBadge = $connection->prepare("SELECT * FROM users NATURAL JOIN badges NATURAL JOIN groups_permissions WHERE keyID=?");
    $sqlUserInfoFromBadge->bind_param("s", $_GET["rfid"]);
    $sqlUserInfoFromBadge->execute();
    $result = $sqlUserInfoFromBadge->get_result();
    $UserExist = $result->num_rows;

    if ($UserExist == 1) {
        $row = $result->fetch_assoc();

        $userEmail = $row["user_email"];


        //Get room id by the room number
        $sqlGetIDRoom = $connection->prepare("SELECT room_id FROM rooms WHERE numroom=?");
        $sqlGetIDRoom->bind_param("s", $_GET["hostname"]);
        $sqlGetIDRoom->execute();
        $result2 = $sqlGetIDRoom->get_result();
        $roomExist = $result2->num_rows;

        if ($roomExist == 1) {
            $row2 = $result2->fetch_assoc();
            $Room = $row2["room_id"];
        } else {
            //Room does not exist
            $data = array('allowed' => false);
            echo json_encode($data);
            die();
        }


        //If the user has the open the door when its free (ex: cleaning staff)
        if ($row["open_doors_when_free"] == 1) {
            $sqlFree = $connection->prepare("SELECT * FROM reserve_details WHERE date=? AND start_time<=? AND end_time>? AND room_id=?");
            $sqlFree->bind_param("siii", $dateNow, $SlotsHours[$HourNow], $SlotsHours[$HourNow], $Room);
            $sqlFree->execute();
            $result3 = $sqlFree->get_result();
            $roomFreeRows = $result3->num_rows;

            if ($roomFreeRows == 0) {
                $data = array('allowed' => true);
                echo json_encode($data);
                die();
            }
        }



        //Check if a book exist
        $sqlBookExist = $connection->prepare("SELECT * FROM reserve_details WHERE date=? AND user_email=? AND start_time<=? AND end_time>? AND room_id=?");
        $sqlBookExist->bind_param("siiii", $dateNow, $userEmail, $SlotsHours[$HourNow], $SlotsHours[$HourNow], $Room);
        $sqlBookExist->execute();
        $result2 = $sqlBookExist->get_result();
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
