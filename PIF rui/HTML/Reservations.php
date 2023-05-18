<?php
include_once("CommonCode.php");


if (!$_SESSION["UserLogged"]) {
    header("Location: Login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../JS/jquery-3.6.3.min.js"></script>
    <script src="../JS/Reservations.js?t=<?= time(); ?>"></script>
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

    <div class="reservation_container">
        <div class="input_container">
            <h3>Reservation Date</h3>
            <input type="date" class="calendar" min="<?php echo date("Y-m-d"); ?>">
        </div>
        <div class="rooms_container">
            <!-- <div class="room" roomid="A11">
                <div class="room-general-info">
                    <p class="room-number">A11</p>
                    <input type="button" value="Reserve" class="room-details">
                </div>
                <div class="room-reservations-info">
                    <div class="room-reservations-container">
                        <div class="time-slot-free" timeid="1">
                            08:00 - 09:00
                        </div>
                        <div class="time-slot-free" timeid="2">
                            09:00 - 10:00
                        </div>
                        <div class="time-slot-free" timeid="3">
                            10:00 - 11:00
                        </div>
                        <div class="time-slot-free" timeid="4">
                            11:00 - 12:00
                        </div>
                        <div class="time-slot-free" timeid="5">
                            12:00 - 13:00
                        </div>
                        <div class="time-slot-free" timeid="6">
                            13:00 - 14:00
                        </div>
                        <div class="time-slot-free" timeid="7">
                            14:00 - 15:00
                        </div>
                        <div class="time-slot-free" timeid="8">
                            15:00 - 16:00
                        </div>
                        <div class="time-slot-free" timeid="9">
                            16:00 - 17:00
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

    </div>




</body>

</html>