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

    <div class="reservation_container">
        <div class="input_container">
            <h3>Reservation Date</h3>
            <input id="inputDate" type="date" class="calendar" min="<?php /*This disables the past days bcs it puts minimal date that it the currect date*/ echo date("Y-m-d"); ?>">

            <select id="start-time">
                <option selected disabled value="-1">Select an hour</option>
            </select>

            <select id="end-time">
                <option value="-1">----</option>
            </select>

            <button id="gobtn" class="btn btn-primary btn-sm">Go</button>
        </div>

    </div>




</body>

</html>