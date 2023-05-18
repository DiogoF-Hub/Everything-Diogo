<?php
include_once("CommonCode.php");

require("../PHP/newReservation.php");


if (!$_SESSION["UserLogged"]) {
    header("Location: Login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../JS/jquery-3.6.3.min.js"></script>
    <script src="../JS/ReservationsNew.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <script src="../CSS/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/Reservations.css?t=<?= time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
</head>

<body>
    <?php
    include_once("Navbar.php");
    ?>

    <br>

    <div class="reservation_container">
        <form id="reservForm" method="GET" class="input_container">

            <?php
            $dateGet = "";
            if (isset($_GET["date"])) {
                $dateGet = $_GET["date"];
            }
            ?>

            <h3>Reservation Date</h3>
            <input value="<?= $dateGet ?>" name="date" id="inputDate" type="date" class="calendar" min="<?php /*This disables the past days bcs it puts minimal date that it the currect date*/ echo date("Y-m-d"); ?>">


            <select name="start-time" id="start-time">
                <option selected disabled value="-1">Select an hour</option>
                <option value="1">08:00</option>
                <option value="2">09:00</option>
                <option value="3">10:00</option>
                <option value="4">11:00</option>
                <option value="5">12:00</option>
                <option value="6">13:00</option>
                <option value="7">14:00</option>
                <option value="8">15:00</option>
                <option value="9">16:00</option>
            </select>

            <?php
            if (isset($_GET["start-time"])) {
            ?>
                <script>
                    optionValue = <?= $_GET["start-time"] ?>;
                    //first it finds the option with that value, that is inside that select and then make that option selected
                    $("#start-time option[value='" + optionValue + "']").attr("selected", true);
                </script>
            <?php
            }
            ?>


            <select name="end-time" id="end-time">
                <option value="-1">----</option>
            </select>


            <?php
            if (isset($_GET["end-time"])) {
            ?>
                <script>
                    hoursArr = {
                        "1": {
                            startTime: "08:00",
                            endTime: "09:00"
                        },
                        "2": {
                            startTime: "09:00",
                            endTime: "10:00"
                        },
                        "3": {
                            startTime: "10:00",
                            endTime: "11:00"
                        },
                        "4": {
                            startTime: "11:00",
                            endTime: "12:00"
                        },
                        "5": {
                            startTime: "12:00",
                            endTime: "13:00"
                        },
                        "6": {
                            startTime: "13:00",
                            endTime: "14:00"
                        },
                        "7": {
                            startTime: "14:00",
                            endTime: "15:00"
                        },
                        "8": {
                            startTime: "15:00",
                            endTime: "16:00"
                        },
                        "9": {
                            startTime: "16:00",
                            endTime: "17:00"
                        }
                    }


                    let a = Number(<?= $_GET["end-time"] ?>);

                    $("#end-time").html("");

                    //choosing changes the end time select
                    $.each(hoursArr, function(index, value) {
                        if (Number(index) >= a) {
                            let myoption3 = `<option value=${(index)}>${value.endTime}</option>`;
                            $("#end-time").append(myoption3);
                        }
                    });
                </script>
            <?php
            }
            ?>

            <button type="button" id="gobtn" class="btn btn-primary btn-sm">Go</button>
        </form>


        <br>


        <?php
        if (isset($_GET["date"], $_GET["start-time"], $_GET["end-time"])) {

            if ($_GET["end-time"] < $_GET["start-time"]) {
        ?>
                <script>
                    var currentPath = window.location.pathname;
                    window.location.href = currentPath;
                </script>
            <?php
            }
            ?>
            <script>
                $("#start-time").attr("disabled", true);
                $("#end-time").attr("disabled", true);
                $("#inputDate").attr("disabled", true);
                $("#gobtn").attr("disabled", true);
            </script>


            <form method="POST" id="reservFormLast">
                <div>Available rooms:</div>
                <select id="roomSelected" name="roomSelected">
                    <option selected disabled value="-1">Select a room</option>
                    <?php
                    $RoomsTaken = [];

                    $endTime = $_GET["end-time"] + 1;

                    $HoursSelected = range($_GET["start-time"], $endTime);


                    $time = strtotime($_GET["date"]);
                    $dataFormated = date('Y-m-d', $time);


                    $sqlGetReservDate = $connection->prepare("SELECT * FROM Reserve_Details WHERE date=?");
                    $sqlGetReservDate->bind_param("s", $dataFormated);
                    $sqlGetReservDate->execute();
                    $result = $sqlGetReservDate->get_result();

                    while ($row = $result->fetch_assoc()) {
                        if (!in_array($row["room_id"], $RoomsTaken)) {

                            if ($row["end-time"] != $_GET["start-time"]) {
                                $rangeRow = range($row["start_time"], $row["end_time"]);
                                for ($i = 0; $i < count($rangeRow); $i++) {
                                    if (in_array($rangeRow[$i], $HoursSelected) && !in_array($row["room_id"], $RoomsTaken)) {
                                        $RoomsTaken[] = $row["room_id"];
                                    }
                                }
                            }
                        }
                    }

                    $sqlGetRooms = $connection->prepare("SELECT * FROM Rooms");
                    $sqlGetRooms->execute();
                    $result2 = $sqlGetRooms->get_result();
                    while ($row2 = $result2->fetch_assoc()) {
                        if (!in_array($row2["room_id"], $RoomsTaken)) {
                    ?>
                            <option value="<?= $row2["room_id"] ?>"><?= $row2["numroom"] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>

                <input type="text" id="purpose" name="purpose" placeholder="purpose">

                <button id="reservBTN" type="button" class="btn btn-primary btn-sm">Reserve</button>
            </form>

            <br><br>


            <form action="newReservation.php">
                <button class="btn btn-secondary btn-sm" type="submit">Reset</button>
            </form>
        <?php
        }
        ?>

    </div>




</body>

</html>