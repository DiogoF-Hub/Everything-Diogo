<?php
include_once("start.php");

if (isset($_GET["ProductID"])) {

    $navbarlanguage = 0;
    $OtherLanguage = "PT";
    $sqlLang = 1;


    if (empty($_SESSION["lang"])) {
        header('Location: ' . "ShowProduct.php?ProductID=" . $_GET["ProductID"] . "&lang=EN#slider-image-1");
        exit();
    } else {
        if (!in_array($_SESSION["lang"], array('EN', 'PT'), true)) {
            die("Wrong Page");
        }
        if ($_SESSION["lang"] == "PT") {
            $navbarlanguage = 5;
            $OtherLanguage = "EN";
            $sqlLang = 2;
        }
    }

    if (!is_numeric($_GET["ProductID"])) {
        die();
    }

    $sqlStatement = $connection->prepare("SELECT * from products natural join description where IDLang=" . $sqlLang . " AND ProductsID=?");
    $sqlStatement->bind_param("s", $_GET["ProductID"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $numberofproducts = $result->num_rows;

    $row = $result->fetch_assoc();
}


?>

<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="../Styling/MyStylesEN.css?t<?= time(); ?>" />
    <title><?= $row["ProductNameFull"] ?></title>

</head>

<body>
    <?php
    include_once("nav.php");
    navbar("ShowProduct.php?ProductID=" . $_GET["ProductID"] . "&lang=" . $OtherLanguage . "#slider-image-1", "products", $navbarlanguage, $_SESSION["lang"]);
    ?>

    <section class="section1">

        <div class="slider-holder">
            <span id="slider-image-1"></span>
            <span id="slider-image-2"></span>
            <span id="slider-image-3"></span>
            <div class="image-holder">
                <img src="../images/<?= $row["ImageLink"] ?>.jpg" class="slider-image" />
                <img src="../images/<?= $row["ImageLink"] ?>2.jpg" class="slider-image" />
                <img src="../images/<?= $row["ImageLink"] ?>3.jpg" class="slider-image" />
            </div>
            <div class="button-holder">
                <a href="#slider-image-1" class="slider-change"></a>
                <a href="#slider-image-2" class="slider-change"></a>
                <a href="#slider-image-3" class="slider-change"></a>
            </div>
        </div>

        <br>

        <div class="CenterBox">
            <div id="testDiv"><?= $row["Description2"] ?></div>

            <table class="styled-table">
                <tr>
                    <th><?php if ($_SESSION["lang"] == "EN") {
                            print "Product Name:";
                        } else {
                            print "Nome do produto:";
                        } ?></th>
                    <th><?= $row["ProductNameFull"] ?></th>
                </tr>

                <tr>
                    <th><?= $row["TableDescription1"] ?></th>
                    <td><?= $row["DetailedTable1"] ?></td>
                </tr>

                <tr>
                    <th><?= $row["TableDescription2"] ?></th>
                    <td><?= $row["DetailedTable2"] ?></td>
                </tr>

                <tr>
                    <th><?= $row["TableDescription3"] ?></th>
                    <td><?= $row["DetailedTable3"] ?></td>
                </tr>

            </table>
        </div>
    </section>

</body>

</html>