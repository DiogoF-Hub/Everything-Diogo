<?php
include_once("start.php");

if ($_SESSION["userloggedIn"] == false) {
    print "<script>alert('You are not logged In');</script>";
    print '<script>window.location.href = "user.php";</script>';
    die();
}

if ($_SESSION["UserType"] != "Admin") {
    header("Location: Home.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--<link rel="icon" href="../Images/Logo.jpg">-->
    <title>Create Product</title>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("createProduct.php?lang=" . $otherlang, "", $sqlLang);
    ?>

    <section class="section1">

        <div class="container">
            <div class="row">

                <div class="form-floating">
                    <input type="text" class="form-control">
                    <label for="floatingInput">Product Name</label>
                </div>

            </div>
        </div>

    </section>
</body>

</html>