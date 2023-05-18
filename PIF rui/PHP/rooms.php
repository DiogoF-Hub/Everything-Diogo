<?php
require("../HTML/CommonCode.php");

// response variable
$response = new stdClass();
// end

// input validation
if (!isset($_GET["date"])) {
    $response->message = "Date no set";
    echo json_encode($response);
    die();
}
// end

// select free rooms on the chosen date
$query = $connection->prepare("SELECT * FROM Rooms WHERE room_id NOT IN (SELECT Rooms.room_id FROM `Rooms` JOIN reserve_details ON Rooms.room_id=reserve_details.room_id WHERE `date`=? GROUP BY room_id)");
$query->bind_param("s", $_GET["date"]);
$query->execute();
$a = $query->get_result();
$rooms = [];

// add rooms to the array
while ($room = $a->fetch_assoc()) {
    $temp = new stdClass();
    $temp->id = $room["room_id"];
    $temp->number = $room["room_id"];
    $rooms[] = $temp;
}

// checks if it worked
$response->message = "Success";
$response->rooms = $rooms;

echo json_encode($response);
