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
    <!-- Here I put jquery file, my js and css files, bootstrap files such as css and js and fontawesome css file -->
    <!-- bootstrap & fontawesome are css libraries -->
    <!-- On all js and css files, I have a time stamp that makes the browser thinks that every time it reloads, there is always different files to loads that helps debugging because it doesn't allow the browser to cache the files -->
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap-icons.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/fontawesome-free-6.2.1-web/css/all.min.css?t=<?= time(); ?>" />
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
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

    <section class="section1" style="background-color: white;">

    </section>
</body>

</html>