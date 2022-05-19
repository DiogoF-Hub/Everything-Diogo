<?php
include_once("start.php");

if (isset($_POST["deleteProductChart"])) {
    if (isset($_SESSION["Chart"][$_POST["deleteProductChart"]])) {
        unset($_SESSION["Chart"][$_POST["deleteProductChart"]]);
    } else {
        die();
    }
}
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



    $sqlStatement = $connection->prepare("SELECT * from products natural join description where IDLang=" . $IDlang);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();

    $totalMulti = 0;
    $totalOrder = 0;
    $totalQuantity = 0;
    ?>

    <section class="section1">

        <?php
        if (isset($_SESSION["Chart"])) {
            foreach ($_SESSION["Chart"] as $productID => $quantity) {
                $totalQuantity = $totalQuantity + $quantity;
            }
        ?>
            <div class="container h-50">
                <div class="row d-flex justify-content-center align-items-center h-50">
                    <div class="col">
                        <p><span class="h3">Shopping Cart </span><span class="h5">(<?= $totalQuantity ?> item(s) in your Shopping-Cart)</span></p>




                        <?php
                        foreach ($_SESSION["Chart"] as $productID => $quantity) {
                            $sqlStatement2 = $connection->prepare("SELECT * from products natural join description where ProductsID=? AND IDLang=" . $IDlang);
                            $sqlStatement2->bind_param("s", $productID);
                            $sqlStatement2->execute();
                            $result2 = $sqlStatement2->get_result();

                            $row = $result2->fetch_assoc();

                            $totalMulti = $row["Price"] * $quantity;
                            $totalOrder = $totalOrder + $totalMulti;
                        ?>


                            <div class="card mb-3">
                                <div class="card-body p-3">

                                    <div class="row align-items-center">
                                        <div class="col">
                                            <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                <img src="../Images/<?= $row["ImageLink"] ?>.jpg" style="height: 50%; width: 50%;" alt="<?= $row["ProductName"] ?>">
                                            </a>
                                        </div>
                                        <div class="col justify-content-center">
                                            <div>
                                                <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                    <div class="small text-muted mb-2 ">Name</div>
                                                    <div class="fw-normal mb-2"><?= $row["ProductName"] ?></div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <div>
                                                <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                    <div class="small text-muted mb-2 ">Type</div>
                                                    <div class="fw-normal mb-2"><?= $row["Subtitle1"] ?></div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <div>
                                                <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                    <div class="small text-muted mb-2 ">Price</div>
                                                    <div class="fw-normal mb-2"><?= $row["Price"] ?>€</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <div>
                                                <div class="small text-muted mb-2 ">Quantity</div>
                                                <div class="fw-normal mb-2">
                                                    <form method="POST">
                                                        <select name="" id="">
                                                            <?php
                                                            for ($i = 1; $i <= 10; $i++) {
                                                            ?>
                                                                <option <?php if ($i == $quantity) print "selected"; ?> value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <div>
                                                <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                    <div class="small text-muted mb-2 ">Total</div>
                                                    <div class="fw-normal mb-2"><?= $totalMulti ?>€</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <div>
                                                <form method="POST">
                                                    <input name="deleteProductChart" value="<?= $productID ?>" type="text" hidden>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php
                        }
                        ?>



                        <div class="card mb-5">
                            <div class="card-body p-4">

                                <div class="float-end">
                                    <p class="mb-1 me-5 d-flex align-items-center">
                                        <span class="small text-muted me-2">Order total:</span> <span class="lead fw-normal"><?= $totalOrder ?>€</span>
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <form method="POST">
                                <button name="order" type="submit" class="btn btn-primary btn-lg">Procede to checkout</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        <?php } else {
            echo "<script> alert('You are not logged In'); </script>";
            echo "<script> window.location.href='user.php' </script>";
        }
        ?>


    </section>

</body>

</html>