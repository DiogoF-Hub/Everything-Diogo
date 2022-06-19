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
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Products</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
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
    navbar("Products.php?lang=" . $otherlang . "&pricerange=" . $_GET["pricerange"], "products", $togle);

    ?>

    <section class="section1">

        <?php
        $Normal = "Normal";
        $Ascending = "Price ascending";

        ?>
        <form method="get" id="pricerange" action="Products.php">

            <select name="pricerange" onchange="pricerangefunc();">
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "normal") echo "selected"; ?> value="normal">Normal</option>
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "price_asc") echo "selected"; ?> value="price_asc">Price ascending</option>
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "price_desc") echo "selected"; ?> value="price_desc">Price descending</option>
            </select>

        </form>

        <?php

        $Productsorder = "";

        if ($_GET["pricerange"] == "price_asc") {
            $Productsorder = " ORDER BY Price ASC";
            //asort($PricesIds); //ascending 1-10
        } else {
            if ($_GET["pricerange"] == "price_desc") {
                $Productsorder = " ORDER BY Price DESC";
                //arsort($PricesIds); //descending 10-1
            }
        }


        $sqlStatement = $connection->prepare("SELECT * from products natural join description where IDLang=" . $IDlang . $Productsorder);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        $numberofproducts = $result->num_rows;

        $lineNumber = 0;
        ?>
        <?php
        if ($numberofproducts == 0) {
            print("<h1>No Products were found :(</h1>");
        } else {

            while ($row = $result->fetch_assoc()) {
                if ($lineNumber == 0)
                    print("<div class='oneLineOfProduct'>");
        ?>
                <div class="product">
                    <a href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1"><img src="../Images/<?= $row["ImageLink"] ?>.jpg" alt="<?= $row["ProductName"] ?>" class="productimage"></a>
                    <div><?= $row["ProductName"] ?></div>
                    <div><?= $row["Subtitle1"] ?></div>
                    <div><?= $row["Subtitle2"] ?></div>
                    <span>----</span>
                    <div><?= $row["Description1"] ?></div>
                    <div><?= $row["Company"] ?></div>
                    <a href="<?= $row["ProductLink"] ?>" target="_blank"><span class="greenPrice"><?= $row["Price"] ?>€</span></a>
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
                        <button type="submit">Buy</button>
                    </form>

                </div>

        <?php
                $lineNumber++;
                if ($lineNumber == 9) {
                    print("</div>");
                    $lineNumber = 0;
                }
            }
        }
        ?>


    </section>
</body>

</html>