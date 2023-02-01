<?php
include_once("commonCodeHTML.php"); //Here I include the common code for the pages that users see, thats why its called HTML

if (!$_SESSION["userloggedIn"] || $_SESSION["group_right_schedule"] != 1) { //Here I check if the user is logged in and if not I will make him go to index.php
    header("Location: index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Here I put jquery file, my js and css files, bootstrap files such as css and js and fontawesome css file -->
    <!-- bootstrap & fontawesome are css libraries -->
    <!-- On all js and css files, I have a time stamp that makes the browser thinks that every time it reloads, there is always different files to loads that helps debugging because it doesn't allow the browser to cache the files -->
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/fontawesome-free-6.2.1-web/css/all.min.css?t=<?= time(); ?>" />
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
    <link rel="stylesheet" href="../CSS/flatpickr.min.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/flatpickr_themes.css?t=<?= time(); ?>">
    <script src="../JS/flatpickr.js?t=<?= time(); ?>"></script>
    <script src='../JS/reservation.js?t=<?= time(); ?>'></script>
    <link rel="icon" type="image/x-icon" href="../IMAGES/logo.png">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Datacorp</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <?php
    nav("reservation", 0); //Here I call the nav bar function from the commonCodeHTML.php
    ?>

    <section class="section1">
        <div class="container d-flex justify-content-center pb-4">
            <div class="card mb-4 border border-dark rounded-3" style="width: 24rem;">
                <div class="card-body p-4">
                    <p class="text-center mb-4"><span class="h2">Create Reservation</span></p>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="inputDate">Date</label>
                        <input type="date" id="inputDate" name="inputDate" class="form-control" aria-describedby="dateHelp" placeholder="Select a date" />
                        <div id="dateHelp" class="form-text">Weekends are not allowed</div>
                        <div style="color: red;"></div>
                    </div>

                    <div class="form-outline mb-4">
                        <div class="row">
                            <div class="col">
                                <label for="startTime" class="form-label">Start Time</label>
                                <select class="form-select" id="startTimeSelect">
                                    <option selected value="-1">Select an hour</option>
                                </select>
                                <div style="color: red;"></div>
                            </div>

                            <div class="col">
                                <label for="endTime" class="form-label">End Time</label>
                                <select class="form-select" id="endTimeSelect" disabled>
                                    <option value="-1">----</option>
                                </select>
                                <div style="color: red;"></div>
                            </div>
                        </div>
                    </div>

                    <div id="extraInfo" class="form-outline mb-4">
                        <hr>
                        <div class="row mb-1">
                            <div class="col-10">
                                <label for="roomsSelect" class="form-label">Available Rooms</label>
                                <select class="form-select" id="roomsSelect">
                                    <option selected disabled value="-1">Select Room</option>
                                </select>
                                <div style="color: red;"></div>
                            </div>

                            <div class="col-2">
                                <label class="form-label">&zwnj;</label>
                                <button id="tooltipDescription" type="button" class="btn btn-light border" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Select a Room to see his description">
                                    ?
                                </button>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <div id="capacityDiv">Room capacity:</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="purpose" class="form-label">Purpose</label>
                                <textarea id="purpose" type="text" class="form-control" placeholder="Purpose of the Reservation"></textarea>
                                <div style="color: red;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
                        <div class="col-md-auto">
                            <button id="resetBtn" type="button" class="btn btn-secondary btn-block btn-lg">Reset</button>
                        </div>
                        <div class="col-md-auto">
                            <button id="SearchRooms" type="button" class="btn btn-info btn-block btn-lg">Search</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>

</html>