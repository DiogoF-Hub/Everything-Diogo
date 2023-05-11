<?php
include_once("commonCodeHTML.php"); //Here I include the common code for the pages that users see, thats why its called HTML

if (!$_SESSION["userloggedIn"]) { //Here I check if the user is logged in and if not I will make him go to index.php
    header("Location: index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Here I put the jquery file, my js and css files, bootstrap files such as css and js and fontawesome css file -->
    <!-- bootstrap & fontawesome are css libraries -->
    <!-- On all js and css files, I have a time stamp that makes the browser thinks that every time it reloads, there is always different files to loads that helps debugging because it doesn't allow the browser to cache the files -->
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
    <script src='../JS/myreservations.js?t=<?= time(); ?>'></script>
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min5.0.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/fontawesome-free-6.2.1-web/css/all.min.css?t=<?= time(); ?>" />
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <link rel="icon" type="image/x-icon" href="../IMAGES/logo.png">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Datacorp</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <?php
    nav("profile", "profile2"); //Here I call the nav bar function from the commonCodeHTML.php
    ?>
    <section class="section1">
        <?php
        $sqlGetReserv = $connection->prepare("SELECT * FROM Booking_info NATURAL JOIN Rooms WHERE user_id=?");
        $sqlGetReserv->bind_param("s", $_SESSION["user_id"]); //bind the user id from the session
        $sqlGetReserv->execute();
        $result = $sqlGetReserv->get_result();
        $totalReserv = $result->num_rows;


        if ($totalReserv > 0) {
        ?>
            <div class="text-center">
                <div class="card mx-auto" style="max-width: 1000px;">
                    <div id="allReservsDiv" class="container card-body">


                        <?php

                        $HoursArr = array_flip([ //slots
                            "8 AM" => "1",
                            "9 AM" => "2",
                            "10 AM" => "3",
                            "11 AM" => "4",
                            "12 PM" => "5",
                            "13 PM" => "6",
                            "14 PM" => "7",
                            "15 PM" => "8",
                            "16 PM" => "9",
                            "17 PM" => "10"
                        ]);



                        $a = 0;

                        while ($row = $result->fetch_assoc()) {
                            $a++;
                        ?>
                            <div>
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <div class="d-inline-block"><span class="active1">Room number: </span><?= $row["number"] ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="d-inline-block"><span class="active1">Date: </span><?= $row["booking_date"] ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="d-inline-block"><span class="active1">Time: </span><?= $HoursArr[$row["start_time"]] ?> - <?= $HoursArr[$row["end_time"]] ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="d-inline-block"><span class="active1">Purpose: </span><?= $row["purpose"] ?></div>
                                    </div>
                                    <div class="col">
                                        <input type="text" hidden value="<?= $row['booking_id']; ?>">
                                        <button class="deleteReservClass btn btn-danger btn-sm" type="button">Delete</button>
                                    </div>
                                </div>

                                <?php if ($a != $totalReserv) {
                                ?>
                                    <hr>
                                <?php
                                } ?>

                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
        } else {
            ?>
                <div class="card mx-auto" style="max-width: 400px;">
                    <h4 class="text-center">No reservations were found</h4>
                </div>

            <?php
        }
            ?>

    </section>
</body>

</html>