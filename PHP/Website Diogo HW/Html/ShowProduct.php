<?php
include_once("start.php");

if (isset($_GET["ProductID"])) {

    /*$navbarlanguage = 0;
    $OtherLanguage = "PT";
    $sqlLang = 1;


    if (empty($_SESSION["lang"])) {
        header('Location: ' . "ShowProduct.php?ProductID=" . $_GET["ProductID"] . "&lang=EN#slider-image-1");
        die();
    } else {
        if (!in_array($_SESSION["lang"], array('EN', 'PT'), true)) {
            $_SESSION["lang"] = 'EN';
        }
        if ($_SESSION["lang"] == "PT") {
            $navbarlanguage = 5;
            $OtherLanguage = "EN";
        }
    }*/

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
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title><?= $row["ProductNameFull"] ?></title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel-control-next,
        .carousel-control-prev,
        .carousel-indicators {
            filter: invert(100%);
        }
    </style>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("ShowProduct.php?ProductID=" . $_GET["ProductID"] . "&lang=" . $otherlang, "products", $sqlLang, $connection);
    ?>

    <section class="section1">

        <div class="container-fluid" style="width: 39%;">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" class="" aria-current="true"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../images/<?= $row["ImageLink"] ?>.jpg" alt="" class="d-block w-100">

                    </div>
                    <div class="carousel-item">
                        <img src="../images/<?= $row["ImageLink"] ?>2.jpg" alt="" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/<?= $row["ImageLink"] ?>3.jpg" alt="" class="d-block w-100">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
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