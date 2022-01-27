<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Products</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
</head>

<body>

    <?php
    include_once("nav.php");
    navbar("ProductsPT.php", "products", 0, "EN");
    ?>

    <section class="section1">

        <?php
        $filename = '../database/database.txt';
        if (file_exists($filename)) {
            $handle = fopen($filename, "r");
            $lineNumber = 0;
            while (($line = fgets($handle)) !== false) {
                $arraytest = explode(";", $line);
                if (count($arraytest) >= 20) {
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
            }
            fclose($handle);
        } else {
            die("File not found");
        }

        ?>


    </section>
</body>

</html>