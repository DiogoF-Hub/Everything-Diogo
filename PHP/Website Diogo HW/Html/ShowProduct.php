<?php

if (isset($_GET["ProductID"])) {

    $toggle = 0;
    $navbarlanguage = 0;
    $OtherLanguage = "PT";


    if (empty($_GET["lang"])) {
        header('Location: ' . "ShowProduct.php?ProductID=" . $_GET["ProductID"] . "&lang=EN#slider-image-1");
        exit();
    } else {
        if (!in_array($_GET["lang"], array('EN', 'PT'), true)) {
            die("Wrong Page");
        }
        if ($_GET["lang"] == "PT") {
            $toggle = 9;
            $navbarlanguage = 5;
            $OtherLanguage = "EN";
        }
    }

    $filename = '../database/database.txt';
    if (file_exists($filename)) {
        $handle = fopen($filename, "r");
        $ProductFound = false;
        while (($line = fgets($handle)) !== false) {
            $arraytest = explode(";", $line);
            if ($_GET["ProductID"] == $arraytest[0]) {
                $ProductFound = true;
                break;
            }
        }

        if ($ProductFound == false) {
            die("This product is not in my data base");
        }
    } else {
        die("The file was not found");
    }
} else {
    die("Page not found");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="../Styling/MyStylesEN.css?t<?= time(); ?>" />
    <title><?= $arraytest[12] ?></title>

</head>

<body>
    <?php
    include_once("nav.php");
    navbar("ShowProduct.php?ProductID=" . $_GET["ProductID"] . "&lang=" . $OtherLanguage . "#slider-image-1", "products", $navbarlanguage, $_GET["lang"]);
    ?>

    <?php echo count($arraytest); ?>

    <section class="section1">

        <div class="slider-holder">
            <span id="slider-image-1"></span>
            <span id="slider-image-2"></span>
            <span id="slider-image-3"></span>
            <div class="image-holder">
                <img src="<?= $arraytest[1] ?>.jpg" class="slider-image" />
                <img src="<?= $arraytest[1] ?>2.jpg" class="slider-image" />
                <img src="<?= $arraytest[1] ?>3.jpg" class="slider-image" />
            </div>
            <div class="button-holder">
                <a href="#slider-image-1" class="slider-change"></a>
                <a href="#slider-image-2" class="slider-change"></a>
                <a href="#slider-image-3" class="slider-change"></a>
            </div>
        </div>
        <div id="testDiv"><?= $arraytest[11 + $toggle] ?></div>

        <table class="styled-table">
            <tr>
                <th><?php if ($_GET["lang"] == "EN") {
                        print "Product Name:";
                    } else {
                        print "Nome do produto:";
                    } ?></th>
                <th><?= $arraytest[12] ?></th>
            </tr>

            <tr>
                <th><?php if ($_GET["lang"] == "PT") {
                        print $arraytest[13 + $toggle - 1];
                    } else {
                        print $arraytest[13];
                    }  ?></th>
                <td><?= $arraytest[14] ?></td>
            </tr>

            <tr>
                <th><?php if ($_GET["lang"] == "PT") {
                        print $arraytest[15 + $toggle - 2];
                    } else {
                        print $arraytest[15];
                    }  ?></th>
                <td><?= $arraytest[16] ?></td>
            </tr>

            <tr>
                <th><?php if ($_GET["lang"] == "PT") {
                        print $arraytest[17 + $toggle - 3];
                    } else {
                        print $arraytest[17];
                    }  ?></th>
                <td><?php if ($arraytest[18] == "Yes" && $_GET["lang"] == "PT") {
                        print "Sim";
                    } else {
                        print $arraytest[18];
                    } ?></td>
            </tr>

        </table>
    </section>

</body>

</html>