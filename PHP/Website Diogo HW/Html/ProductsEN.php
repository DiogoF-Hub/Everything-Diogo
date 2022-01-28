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
    include_once("nav.php");
    navbar("ProductsPT.php", "products", 0, "EN");
    ?>

    <section class="section1">

        <form method="get" id="pricerange">

            <select name="pricerange" onchange="pricerangefunc();">
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "normal") echo "selected"; ?> value="normal">Normal</option>
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "price_asc") echo "selected"; ?> value="price_asc">Price ascending</option>
                <option <?php if (isset($_GET["pricerange"]) && $_GET["pricerange"] == "price_desc") echo "selected"; ?> value="price_desc">Price descending</option>
            </select>

        </form>

        <?php

        if (isset($_GET["pricerange"])) {
            if (!in_array($_GET["pricerange"], array("normal", "price_asc", "price_desc"))) {
                die();
            }
        } else {
            $_GET["pricerange"] = "normal";
        }


        $PricesIds = [];
        $filename = '../database/database.txt';
        if (file_exists($filename)) {
            $handle = fopen($filename, "r");
            while (($line = fgets($handle)) !== false) {
                $arraytest = explode(";", $line);
                if (count($arraytest) >= 20) {
                    $Price = trim($arraytest[10]);
                    $Price2 = explode("€", $Price);
                    $PricesIds[$arraytest[0]] = (int)$Price2[0];
                }
            }
            fclose($handle);



            if ($_GET["pricerange"] == "price_asc") {
                asort($PricesIds); //ascending 1-10
            } else {
                if ($_GET["pricerange"] == "price_desc") {
                    arsort($PricesIds); //descending 10-1
                }
            }



            $lineNumber = 0;

            foreach ($PricesIds as $id => $price) {
                $idnumber = substr($id, 0, -1); //remove the letter from my productId    ex: like "1a" to only "1"

                $file = new SplFileObject($filename); //read a certain line from the txt file withut reading the whole file
                $file->seek($idnumber - 1);

                $arraytest = explode(";", $file->current());


                if ($lineNumber == 0)
                    print("<div class='oneLineOfProduct'>");
        ?>
                <div class="product">
                    <a href="ShowProduct.php?ProductID=<?= trim($arraytest[0]) ?>&lang=EN#slider-image-1"><img src="<?= trim($arraytest[1]) ?>.jpg" alt="<?= trim($arraytest[2]) ?>" class="productimage"></a>
                    <div><?= trim($arraytest[3]) ?></div>
                    <div><?= trim($arraytest[4]) ?></div>
                    <div><?= trim($arraytest[5]) ?></div>
                    <span><?= trim($arraytest[6]) ?></span>
                    <div><?= trim($arraytest[7]) ?></div>
                    <div><?= trim($arraytest[8]) ?></div>
                    <a href="<?= trim($arraytest[9]) ?>" target="_blank"><span class="greenPrice"><?= trim($arraytest[10]) ?></span></a>
                </div>

        <?php
                $lineNumber++;
                if ($lineNumber == 9) {
                    print("</div>");
                    $lineNumber = 0;
                }
            }
        } else {
            die("File not found");
        }

        ?>


    </section>
</body>

</html>