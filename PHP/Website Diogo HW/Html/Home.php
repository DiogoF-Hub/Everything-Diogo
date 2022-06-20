<?php
include_once("start.php");
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen" href="../Styling/MyStylesEN.css?t<?= time(); ?>" />
</head>

<body>
    <?php

    include_once("nav.php");
    navbar("Home.php?lang=" . $otherlang, "home", $sqlLang, $connection);
    ?>

    <section class="section1">
        <div class="divHome1">
            <h1 id="homeH1">Diogo's Website</h1>
            <h3>Welcome, this is my website:</h3>
            <div>
                Here in this website I'm selling some computers parts and it's located on
                <a class="texthoverhome" href="ProductsEN.php">Products</a>
            </div>
            <div>If you want to contact me, you can go to Contact on top and click one of the 3 options</div>
            <div>And if you want have some infos you can find out in <a class="texthoverhome" href="AboutEN.php">About</a></div>
        </div>



        <div class="iframeHome">

            <div class="iframeMaps">
                <h3>My shop is located on <span><a class="texthoverhome" href="https://g.page/LDLC-Thionville?share" target="_blank">Thionville, France:</a></span></h3>
                <?php
                if ($_SESSION["lang"] == "EN") {
                ?>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2598.681113527863!2d6.1374420156921!3d49.35818387933961!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x82339546d60d9b3e!2sLDLC%20Thionville!5e0!3m2!1sen!2slu!4v1650558944794!5m2!1sen!2slu" width="300" height="200" frameborder="0"></iframe>
                <?php
                } else {
                ?>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10394.724428609095!2d6.139631!3d49.358184!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x82339546d60d9b3e!2sLDLC%20Thionville!5e0!3m2!1spt-PT!2slu!4v1650559093995!5m2!1spt-PT!2slu" width="300" height="200" frameborder="0"></iframe>
                <?php } ?>
            </div>

            <div class="iframeMaps">
                <a href="https://www.ldlc.com" target="_blank">
                    <img class="ldlcLogo" src="../Images/LDLC%20logo.jpg" alt="LDLC Logo">
                </a>
            </div>

            <div class="iframeMaps">
                <h3>Here is one video about our shop:</h3>
                <iframe class="iframe1" src="https://www.youtube.com/embed/508s1cz1phs?hl=<?= $_SESSION["lang"] ?>&persist_hl=1" frameborder="0"></iframe>
            </div>
        </div>



    </section>
</body>

</html>