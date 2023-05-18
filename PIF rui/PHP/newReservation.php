<?php
if (isset($_GET["date"], $_GET["start-time"], $_GET["end-time"], $_POST["roomSelected"], $_POST["purpose"])) {
    if ($_GET["end-time"] < $_GET["start-time"] || !is_numeric($_POST["roomSelected"]) || $_POST["roomSelected"] == "-1" || $_POST["purpose"] === "") {
        header("Location: Home.php");
        die();
    }



    //check if the room is really available
    $RoomsTaken = [];
    $HoursSelected = range($_GET["start-time"], $_GET["end-time"] + 1);


    $time = strtotime($_GET["date"]);
    $dataFormated = date('Y-m-d', $time);


    $sqlGetReservDate = $connection->prepare("SELECT * FROM Reserve_Details WHERE 'date'=?");
    $sqlGetReservDate->bind_param("s", $dataFormated);
    $sqlGetReservDate->execute();
    $result = $sqlGetReservDate->get_result();

    while ($row = $result->fetch_assoc()) {
        if (!in_array($row["room_id"], $RoomsTaken)) {
            $rangeRow = range($row["start_time"], $row["end_time"]);
            for ($i = 0; $i < count($rangeRow); $i++) {
                if (in_array($rangeRow[$i], $HoursSelected) && !in_array($row["room_id"], $RoomsTaken)) {
                    $RoomsTaken[] = $row["room_id"];
                }
            }
        }
    }


    if (in_array($_POST["roomSelected"], $RoomsTaken)) {
        header("Location: Home.php");
        die();
    }

    $endTime = $_GET["end-time"] + 1;

    $sqlInsertReserv = $connection->prepare("INSERT INTO `Reserve_Details` (`purpose`, `room_id`, `date`, `user_email`, `start_time`, `end_time`) VALUES(?, ?, ?, ?, ? ,?);");
    $sqlInsertReserv->bind_param("ssssss", $_POST["purpose"], $_POST["roomSelected"], $_GET["date"], $_SESSION["email"], $_GET["start-time"], $endTime);
    if ($sqlInsertReserv->execute()) {
        print '<script>
        alert("The room was reserved");
        var currentPath = window.location.pathname;
        window.location.href = currentPath;
        </script>';
    }
}
