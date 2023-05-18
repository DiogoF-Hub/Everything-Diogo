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
    <script src="../JS/main.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <script src="../CSS/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <?php
    include_once("Navbar.php");
    ?>
    <br><br>
    <h1 class="container d-flex align-items-center justify-content-center">Welcome to Datacorp</h1>
</body>

</html>