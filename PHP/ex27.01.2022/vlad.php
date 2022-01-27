<!DOCTYPE html>
<!-- saved from url=(0040)http://192.168.6.13:5021/Vlad/iphone.php -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="vlad.css">
    <title>iPhone</title>
</head>

<body>

    <div class="wrapper">
        <nav>
            <div class="appleNav">
                <ul>
                    <li>
                        <a href="http://192.168.6.13:5021/Vlad/iphone.php"><img src="./iPhone_files/apple.png" height="20"></a>
                    </li>
                    <li><a href="http://192.168.6.13:5021/Vlad/ipad.php">iPad</a></li>
                    <li><a href="http://192.168.6.13:5021/Vlad/iphone.php">iPhone</a></li>
                    <li><a href="http://192.168.6.13:5021/Vlad/watch.php">Watch</a></li>
                    <li><a href="http://192.168.6.13:5021/Vlad/support.php">Support</a></li>
                    <li>
                        <a href="http://192.168.6.13:5021/Vlad/Website/Html_Eng/about.html"><img src="./iPhone_files/search.png" height="20"></a>
                    </li>
                    <li><a href="http://192.168.6.13:5021/Vlad/iphone.php#">User</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="centermain">
        <h1> iPhone 13 Pro </h1>
        <h3> Oh.So.Pro </h3>
        <div class="price"> 1.149€</div>
        <p>
            <a href="http://192.168.6.13:5021/Vlad/iphone.php" class="bottom-btn1">Buy</a>
            <a href="http://192.168.6.13:5021/Vlad/iphone.php" class="bottom-btn2">Learn more</a>
        </p>
        <div class="pro_overview_div">
            <img src="iphone-13-pro_overview.png" alt="*" class="iPhone_image_Property">
        </div>

    </div>
    <div class="allin">


        <?php

        $filename = 'vlad.txt';
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            $arraytest = explode(";", $line);
        ?>

            <div class="<?= $arraytest[1] ?>">
                <img src="<?= $arraytest[2] ?>.jpg" alt="*" class="iPhone_image_Property">
                <div class="center">
                    <h2> <?= $arraytest[3] ?> </h2>
                    <div>
                        <p>
                        </p>
                        <div> <?= $arraytest[4] ?> </div>
                        <div> <?= $arraytest[5] ?> </div>
                        <div> <?= $arraytest[6] ?>€
                        </div>
                        <p>
                            <a class="bottom-btn1">Buy</a>
                            <a class="bottom-btn2">Learn more</a>
                        </p>
                    </div>
                </div>
            </div>

        <?php
        }

        ?>


    </div>
</body>

</html>