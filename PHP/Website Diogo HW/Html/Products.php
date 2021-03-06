<?php
include_once("start.php");


if (isset($_POST["productBuyId"], $_POST["productBuyTimes"])) {
    if ($_SESSION["userloggedIn"] == false) {
        echo "<script> alert('You are not logged In'); </script>";
        echo "<script> window.location.href='user.php' </script>";
    } else {
        if (is_numeric($_POST["productBuyTimes"])) {
            if ($_POST["productBuyTimes"] < 1 || $_POST["productBuyTimes"] > 10) {
                die();
            }

            $sqlStatement2 = $connection->prepare("SELECT * from products WHERE ProductsID=?");
            $sqlStatement2->bind_param("s", $_POST["productBuyId"]);
            $sqlStatement2->execute();
            $result2 = $sqlStatement2->get_result();


            if ($result2->num_rows == 0) {
                die();
            } else {

                if (isset($_SESSION["Chart"][$_POST["productBuyId"]])) {
                    $_SESSION["Chart"][$_POST["productBuyId"]] = $_SESSION["Chart"][$_POST["productBuyId"]] + $_POST["productBuyTimes"];
                    //unset($_SESSION["Chart"][$_POST["productBuyId"]]);
                } else {
                    $_SESSION["Chart"] += [$_POST["productBuyId"] => $_POST["productBuyTimes"]];
                }
            }
        } else {
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Products</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script>
        function pricerangefunc() {
            document.getElementById("pricerange").submit();
        }
    </script>
</head>

<body>



    <?php


    if (isset($_GET["pricerange"])) {
        if (!in_array($_GET["pricerange"], array("normal", "price_asc", "price_desc"))) {
            $_GET["pricerange"] = "normal";
        }
    } else {
        $_GET["pricerange"] = "normal";
    }


    include_once("nav.php");
    navbar("Products.php?lang=" . $otherlang . "&pricerange=" . $_GET["pricerange"], "products", $sqlLang);

    ?>

    <section class="section1">

        <?php
        $Normal = "Normal";
        $Ascending = "Price ascending";

        ?>
        <form method="get" id="pricerange" action="Products.php">

            <select name="pricerange" onchange="pricerangefunc();">
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "normal") echo "selected"; ?> value="normal">Normal</option>
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "price_asc") echo "selected"; ?> value="price_asc"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                print "Price ascending";
                                                                                                                                            } else {
                                                                                                                                                print "Pre??o ascendente";
                                                                                                                                            } ?></option>
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "price_desc") echo "selected"; ?> value="price_desc"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                print "Price descending";
                                                                                                                                            } else {
                                                                                                                                                print "Pre??o descendente";
                                                                                                                                            } ?></option>
            </select>

        </form>

        <?php

        $Productsorder = "";

        if ($_GET["pricerange"] == "price_asc") {
            $Productsorder = " ORDER BY Price ASC";
        } else {
            if ($_GET["pricerange"] == "price_desc") {
                $Productsorder = " ORDER BY Price DESC";
            }
        }


        $sqlStatement = $connection->prepare("SELECT * from products natural join description where IDLang=" . $sqlLang . $Productsorder);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();

        $lineNumber = 0;
        ?>
        <?php
        while ($row = $result->fetch_assoc()) {
            if ($lineNumber == 0)
                print("<div class='oneLineOfProduct'>");
        ?>
            <div class="Myproduct">
                <a href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>"><img src="../Images/<?= $row["ImageLink"] ?>.jpg" alt="<?= $row["ProductNameFull"] ?>" class="productimage"></a>
                <div><?= $row["ProductNameFull"] ?></div>
                <div><?= $row["Subtitle1"] ?></div>
                <div><?= $row["Subtitle2"] ?></div>
                <span>----</span>
                <div><?= $row["Description1"] ?></div>
                <div><?= $row["Company"] ?></div>
                <a href="<?= $row["ProductLink"] ?>" target="_blank"><span class="greenPrice"><?= $row["Price"] ?>???</span></a>
                <form method="POST">
                    <input name="productBuyId" value="<?= $row["ProductsID"] ?>" type="text" hidden>
                    <select name="productBuyTimes">
                        <?php
                        for ($i = 1; $i <= 10; $i++) {
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button type="submit"><?php if ($_SESSION["lang"] == "EN") {
                                                print "Buy";
                                            } else {
                                                print "Comprar";
                                            } ?></button>
                </form>

            </div>

        <?php
            $lineNumber++;
            if ($lineNumber == 9) {
                print("</div>");
                $lineNumber = 0;
            }
        }
        ?>


    </section>
</body>

</html>