<?php
require("../HTML/CommonCode.php");

$response = new stdClass();

if (!isset($_POST["roomid"]) || !isset($_POST["resarr"]) || !isset($_POST["date"]) || !isset($_POST["purpose"])) {
    $response->message = "Bad input data";
    echo json_encode($response);
    die();
}

$resarr = json_decode($_POST["resarr"]);
sort($resarr);
$max = $resarr[count($resarr) - 1];
$min = $resarr[0];

//Check if existing reservations contain min/max inside them
$selectReservations = $connection->prepare("SELECT MIN(reserve_time_id) AS `mintime`, MAX(reserve_time_id) as `maxtime` FROM reserve_list JOIN reserve_details ON reserve_list.reservation_id=reserve_details.reservation_id JOIN rooms ON rooms.room_id = reserve_details.room_id WHERE reserve_details.date = ? AND reserve_details.room_id=? GROUP BY reserve_details.reservation_id");
$selectReservations->bind_param("ss", $_POST["date"], $_POST["roomid"]);
$selectReservations->execute();
$a = $selectReservations->get_result();
if (mysqli_num_rows($a) != 0) { // check if room has any reservations for this date. If has return error
    $response->message = "Occupied";
    echo json_encode($response);
    die();
}

$reserve = $connection->prepare("INSERT INTO reserve_details (reservation_id, purpose, room_id, `date`, user_email) VALUES (NULL, ?, ?, ?, ?)"); // insert reservation info into reserve_details
$reserve->bind_param("ssss", $_POST["purpose"], $_POST["roomid"], $_POST["date"],  $_SESSION["email"]);
$reserve->execute();

$lastinsert = $connection->prepare("SELECT LAST_INSERT_ID() as ls"); // get last insert id
$lastinsert->execute();
$a = $lastinsert->get_result();
$lastinsert = $a->fetch_assoc();
$lastinsert = $lastinsert["ls"];

for ($i = 0; $i < count($resarr); $i++) { // Insert time id's into reserve_list
    $restime = $connection->prepare("INSERT INTO reserve_list(id, reservation_id, reserve_time_id) VALUES (NULL, ?, ?)");
    $restime->bind_param("ss", $lastinsert, $resarr[$i]);
    $restime->execute();
}
$response->message = "reserved";
echo json_encode($response);
