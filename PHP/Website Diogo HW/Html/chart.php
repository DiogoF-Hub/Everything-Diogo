<?php
include_once("start.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../bootstrap/js/bootstrap.bundle.min.js'></script>
    <title>Chart</title>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("chart.php?lang=" . $otherlang, "chart", $togle);
    ?>

    <section class="section1">
        <div>
            <div class="productBasket">
                <img class="productimage basketdiv" src="../Images/AMD%203800X.jpg" alt="">
                <div class="basketdiv">AMD Ryzen 7 3800X </div>
                <div class="basketdiv"> 8-Core 16-Threads</div>
                <div class="basketdiv">(3.9 GHz / 4.5 GHz)</div>
            </div>
        </div>

        <?php print_r($_SESSION["Chart"]); ?>
    </section>

</body>

</html>