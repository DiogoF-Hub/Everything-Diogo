<?php
include_once("start.php");

if ($_SESSION["userloggedIn"] == false) {
    if ($_SESSION["lang"] == "EN") {
        print "<script>alert('You are not logged In');</script>";
    } else {
        print "<script>alert('Você não está logado');</script>";
    }
    print '<script>window.location.href = "user.php";</script>';
    die();
}

if (isset($_POST["deleteProductChart"])) {
    if (isset($_SESSION["Chart"][$_POST["deleteProductChart"]])) {
        unset($_SESSION["Chart"][$_POST["deleteProductChart"]]);
    } else {
        die();
    }
    header("Refresh:0");
    die();
}

if (isset($_POST["quantityProduct"], $_POST["quantityProductChartId"])) {
    if (!is_numeric($_POST["quantityProduct"])) {
        die();
    }

    if ($_POST["quantityProduct"] < 1) {
        die();
    }

    if (!isset($_SESSION["Chart"][$_POST["quantityProductChartId"]])) {
        die();
    } else {
        $_SESSION["Chart"][$_POST["quantityProductChartId"]] = $_POST["quantityProduct"];
    }
    header("Refresh:0");
    die();
}

if (isset($_POST["deletechart"])) {
    unset($_SESSION["Chart"]);
    $_SESSION["Chart"] = [];
    header("Refresh:0");
    die();
}

if (isset($_POST["orderSave"])) {
    if (count($_SESSION["Chart"]) > 0) {
        $OrderId = "#" . $_SESSION["username"] . time();
        // start inserting
        $sqlInsert = $connection->prepare("INSERT INTO Orders(OrderID, UserID, StatusOrder) VALUES(?, ?, 0)");
        $sqlInsert->bind_param("si", $OrderId, $_SESSION["UserID"]);
        $sqlInsert->execute();

        // insert items in to the list table

        foreach ($_SESSION["Chart"] as $productID => $quantity) {
            $sqlInsert = $connection->prepare("INSERT INTO ListOrder(ProductsID, QuantityProduct, OrderID) VALUES(?,?,?)");
            $sqlInsert->bind_param("iis", $productID, $quantity, $OrderId);
            $sqlInsert->execute();
        }

        $_SESSION["Chart"]  = [];
        if ($_SESSION["lang"] == "EN") {
            print "<script>alert('You just placed your order!!!');</script>";
        } else {
            print "<script>alert('Você acabou de fazer seu pedido!!!');</script>";
        }
        header("Refresh:0");
        die();
    } else {
        if ($_SESSION["lang"] == "EN") {
            print "<script>alert('Your Shopping-cart is empty');</script>";
        } else {
            print "<script>alert('Seu carrinho de compras está vazio');</script>";
        }
        header("Refresh:0");
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <title>Chart</title>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("chart.php?lang=" . $otherlang, "chart", $sqlLang);



    $sqlStatement = $connection->prepare("SELECT * from products natural join description where IDLang=" . $sqlLang);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();

    $totalMulti = 0;
    $totalOrder = 0;
    $totalQuantity = 0;
    ?>

    <section class="section1">

        <?php
        foreach ($_SESSION["Chart"] as $productID => $quantity) {
            $totalQuantity = $totalQuantity + $quantity;
        }
        ?>
        <div class="container h-50">
            <div class="row d-flex justify-content-center align-items-center h-50">
                <div class="col">
                    <div class="container d-flex">
                        <div class="col">
                            <p><span class="h3"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "Shopping Cart";
                                                } else {
                                                    print "Carrinho de compras";
                                                } ?> </span><span class="h5">(<?= $totalQuantity ?> <?php if ($_SESSION["lang"] == "EN") {
                                                                                                        print "item(s) in your Shopping-Cart)";
                                                                                                    } else {
                                                                                                        print "item(ns) em seu carrinho de compras)";
                                                                                                    } ?></span></p>

                        </div>
                        <div class="col">
                            <style>
                                .wrapper {
                                    float: left;
                                    clear: left;
                                    display: table;
                                    table-layout: fixed;
                                }

                                img.img-responsive {
                                    display: table-cell;
                                    min-width: 25%;
                                }
                            </style>
                            <a class="wrapper col-md-3" href="javascript:{}" onclick="document.getElementById('deletechartId').submit();">
                                <img class="img-responsive" src="../Images/trash.png" alt="trash" style="width: 7%;">
                            </a>

                            <form method="POST" id="deletechartId" hidden>
                                <input name="deletechart" type="text" hidden>
                            </form>
                        </div>
                    </div>


                    <?php
                    foreach ($_SESSION["Chart"] as $productID => $quantity) {
                        $sqlStatement2 = $connection->prepare("SELECT * from products natural join description where ProductsID=? AND IDLang=" . $sqlLang);
                        $sqlStatement2->bind_param("s", $productID);
                        $sqlStatement2->execute();
                        $result2 = $sqlStatement2->get_result();

                        $row = $result2->fetch_assoc();

                        $totalMulti = $row["Price"] * $quantity;
                        $totalOrder = $totalOrder + $totalMulti;
                    ?>


                        <div class="card mb-3">
                            <div class="card-body p-4">

                                <div class="row align-items-center">
                                    <div class="col">
                                        <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                            <img class="img-fluid mx-auto d-block" src="../Images/<?= $row["ImageLink"] ?>.jpg" alt="<?= $row["ProductNameFull"] ?>">
                                        </a>
                                    </div>
                                    <div class="col justify-content-center">
                                        <div>
                                            <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                <div class="small text-muted mb-2 "><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Name";
                                                                                    } else {
                                                                                        print "Nome";
                                                                                    } ?></div>
                                                <div class="fw-normal mb-2"><?= $row["ProductNameFull"] ?></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <div>
                                            <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                <div class="small text-muted mb-2 "><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Info";
                                                                                    } else {
                                                                                        print "Informação";
                                                                                    } ?></div>
                                                <div class="fw-normal mb-2"><?= $row["Subtitle1"] ?></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <div>
                                            <a style="text-decoration: none; color: inherit;" href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                                <div class="small text-muted mb-2 "><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Price";
                                                                                    } else {
                                                                                        print "Preço";
                                                                                    } ?></div>
                                                <div class="fw-normal mb-2"><?= $row["Price"] ?>€</div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <div>
                                            <div class="small text-muted mb-2 "><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Quantity";
                                                                                } else {
                                                                                    print "Quantidade";
                                                                                } ?></div>
                                            <div class="fw-normal mb-2">
                                                <form method="POST" id="quantityProductId<?= $productID ?>">
                                                    <input name="quantityProductChartId" value="<?= $productID ?>" type="text" hidden>
                                                    <select name="quantityProduct" onchange="document.getElementById('quantityProductId<?= $productID ?>').submit();">
                                                        <?php
                                                        $iOptions = 0;
                                                        $iOptions = $iOptions + $quantity;
                                                        if ($iOptions < 10) {
                                                            $iOptions = 10;
                                                        }
                                                        for ($i = 1; $i <= $iOptions; $i++) {
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
                                                <button type="submit" class="btn btn-danger"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                    print "Delete";
                                                                                                } else {
                                                                                                    print "Excluir";
                                                                                                } ?></button>
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
                                    <span class="small text-muted me-2"><?php if ($_SESSION["lang"] == "EN") {
                                                                            print "Order total";
                                                                        } else {
                                                                            print "Total pedido";
                                                                        } ?>:</span> <span class="lead fw-normal"><?= $totalOrder ?>€</span>
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <form method="POST">
                            <button name="orderSave" type="submit" class="btn btn-primary btn-lg"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                        print "Proceed to checkout";
                                                                                                    } else {
                                                                                                        print "Fazer o check-out";
                                                                                                    } ?></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </section>

</body>

</html>