<?php
include_once("start.php");

if ($_SESSION["userloggedIn"] == false) {
    print "<script>alert('You are not logged In');</script>";
    print '<script>window.location.href = "user.php";</script>';
    die();
}


if ($_SESSION["UserType"] != "Admin") {
    print "<script>alert('You are not an Admin');</script>";
    print '<script>window.location.href = "Home.php";</script>';
    die();
}

if (isset($_POST["deleteOrder"], $_POST["OrderID"])) {
    $sqlStatement = $connection->prepare("SELECT * FROM Orders WHERE OrderID=?");
    $sqlStatement->bind_param("s", $_POST["OrderID"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $numberOfOrders = $result->num_rows;

    if ($numberOfOrders == 0) {
        print "<script>alert('The order does not exist');</script>";
        header("Refresh:0");
        die();
    } else {
        $sqlStatement = $connection->prepare("DELETE FROM ListOrder WHERE OrderID=?");
        $sqlStatement->bind_param("s", $_POST["OrderID"]);
        $sqlStatement->execute();

        $sqlStatement = $connection->prepare("DELETE FROM Orders WHERE OrderID=?");
        $sqlStatement->bind_param("s", $_POST["OrderID"]);
        $sqlStatement->execute();

        if (isset($_POST["GETclear"])) {
            header("Location: orders.php");
        } else {
            header("Refresh:0");
        }
        die();
    }
}



if (isset($_POST["ProductsIDInput"], $_POST["deleteProductFromOrder"], $_GET["OrderID"])) {
    $sqlStatement = $connection->prepare("SELECT * from ListOrder WHERE OrderID=? AND ProductsID=?");
    $sqlStatement->bind_param("si", $_GET["OrderID"], $_POST["ProductsIDInput"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $numberOfProduct = $result->num_rows;

    if ($numberOfProduct == 0) {
        print "<script>alert('The product " . $_POST["ProductsIDInput"] . "ID does not exist in the database');</script>";
        header("Refresh:0");
        die();
    } else {
        //print "<script>alert('" . $_GET["OrderID"] . "');</script>";
        $sqlStatement = $connection->prepare("DELETE FROM ListOrder WHERE OrderID=? AND ProductsID=?");
        $sqlStatement->bind_param("si", $_GET["OrderID"], $_POST["ProductsIDInput"]);
        $sqlStatement->execute();

        $sqlStatement = $connection->prepare("SELECT * from ListOrder WHERE OrderID=?");
        $sqlStatement->bind_param("s", $_GET["OrderID"]);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        $numberOfProduct1 = $result->num_rows;

        if ($numberOfProduct1 == 0) {
            $sqlStatement = $connection->prepare("DELETE FROM Orders WHERE OrderID=?");
            $sqlStatement->bind_param("s", $_GET["OrderID"]);
            $sqlStatement->execute();
            header("Location: orders.php");
            die();
        }

        header("Refresh:0");
        die();
    }
}

if (isset($_POST["quantityOrderChange"], $_POST["ProductsIDquantityOrder"], $_GET["OrderID"])) {
    $sqlStatement = $connection->prepare("SELECT * from ListOrder WHERE OrderID=? AND ProductsID=?");
    $sqlStatement->bind_param("si", $_GET["OrderID"], $_POST["ProductsIDquantityOrder"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $numberOfProduct1 = $result->num_rows;

    if ($numberOfProduct1 == 0) {
        print "<script>alert('The product " . $_POST["ProductsID"] . "ID does not exist in this Order');</script>";
    } else {
        if ($_POST["quantityOrderChange"] == 0) {

            $sqlStatement = $connection->prepare("SELECT * from ListOrder WHERE OrderID=?");
            $sqlStatement->bind_param("s", $_GET["OrderID"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $numberOfProductInthisOrder = $result->num_rows;

            $sqlStatement = $connection->prepare("DELETE FROM ListOrder WHERE OrderID=? AND ProductsID=?");
            $sqlStatement->bind_param("si", $_GET["OrderID"], $_POST["ProductsIDquantityOrder"]);
            $sqlStatement->execute();

            if ($numberOfProductInthisOrder == 1) {
                $sqlStatement = $connection->prepare("DELETE FROM Orders WHERE OrderID=?");
                $sqlStatement->bind_param("s", $_GET["OrderID"]);
                $sqlStatement->execute();
                header("Location: orders.php");
                die();
            }
        } else {
            if ($_POST["quantityOrderChange"] != "") {
                $sqlStatement = $connection->prepare("UPDATE ListOrder SET QuantityProduct=? WHERE ProductsID=? AND OrderID=?");
                $sqlStatement->bind_param("iis", $_POST["quantityOrderChange"], $_POST["ProductsIDquantityOrder"], $_GET["OrderID"]);
                $sqlStatement->execute();
            } else {
                print "<script>alert('Quantity must be defined');</script>";
            }
        }
    }
    header("Refresh:0");
    die();
}


if (isset($_POST["OrderIDStatus"], $_POST["OrderStatus"])) {
    $sqlStatement = $connection->prepare("SELECT StatusOrder from Orders WHERE OrderID=?");
    $sqlStatement->bind_param("s", $_POST["OrderIDStatus"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $OrderExist = $result->num_rows;

    if ($OrderExist == 1) {
        $row = $result->fetch_assoc();
        if (!in_array($_POST["OrderStatus"], array("0", "1"))) {
            header("Refresh:0");
            die();
        } else {
            if ($_POST["OrderStatus"] != $row["StatusOrder"]) {
                $sqlStatement = $connection->prepare("UPDATE Orders SET StatusOrder=? WHERE OrderID=?");
                $sqlStatement->bind_param("is", $_POST["OrderStatus"], $_POST["OrderIDStatus"]);
                $sqlStatement->execute();
            }
        }
    } else {
        print "<script>alert('Order does not exist');</script>";
    }
    header("Refresh:0");
    die();
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
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../Styling/form-validation.css?t<?= time(); ?>" rel="stylesheet">
    <script>
        function runWithEnter(event, formID) {
            if (event.keyCode === 13) {
                document.getElementById(formID).submit();
            }
        }
    </script>
    <title>Orders</title>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("orders.php?lang=" . $otherlang, "user", $sqlLang);
    ?>

    <section class="section1">
        <?php
        if (!isset($_GET["OrderID"])) {
        ?>
            <div class="col bg-white">
                <div class="p-3" style="width: 200px;">
                    <div class="e-navlist e-navlist--active-bg">
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link px-2" href="createProduct.php"><i class="fa fa-plus-square mr-1"></i><span> Create Product</span></a></li>
                            <li class="nav-item"><a class="nav-link px-2" href="user.php"><i class="fa fa-undo mr-1"></i><span> Go back</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>OrderID</th>
                            <th>User Info</th>
                            <th>Status</th>
                            <th>Order Total</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlStatement2 = $connection->prepare("SELECT * FROM AllorderTotal");
                        $sqlStatement2->execute();
                        $result2 = $sqlStatement2->get_result();

                        while ($row = $result2->fetch_assoc()) {
                        ?>
                            <tr>
                                <td>
                                    <p class="fw-bold mb-1"><?= $row["OrderID"] ?></p>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php
                                                    if (empty($row["ProfilePic"])) {
                                                        print "../Images/noIMG.jpg";
                                                    } else {
                                                        print "../database/ProfilePics/" . $row["ProfilePic"];
                                                    }
                                                    ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1"><?= $row["FirstName"] . " " . $row["LastName"] ?></p>
                                            <p class="text-muted mb-0"><?= $row["UserName"] ?></p>
                                            <p class="text-muted mb-0"><?= $row["Email"] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" id="changeStatusForm<?= $row["OrderID"] ?>">
                                        <select onchange="document.getElementById('changeStatusForm<?= $row['OrderID'] ?>').submit();" class="form-control w-50" name="OrderStatus" style="color: <?php
                                                                                                                                                                                                    if ($row["StatusOrder"] == 0) {
                                                                                                                                                                                                        print "red";
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        print "green";
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>;">
                                            <option <?php if ($row["StatusOrder"] == "0") print "Selected" ?> style="color:red;" value="0">In progress</option>
                                            <option <?php if ($row["StatusOrder"] == "1") print "Selected" ?> style="color:green;" value="1">Done</option>
                                        </select>
                                        <input name="OrderIDStatus" type="text" hidden value="<?= $row['OrderID'] ?>">
                                    </form>
                                </td>
                                <td><?= $row["TotalOrder"] ?>€</td>
                                <td>
                                    <form method="GET">
                                        <input name="OrderID" type="text" hidden value="<?= $row["OrderID"] ?>">
                                        <button type="submit" class="btn btn-link btn-sm fw-bold">Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input name="OrderID" type="text" hidden value="<?= $row["OrderID"] ?>">
                                        <button name="deleteOrder" type="submit" class="btn btn-danger btn-sm fw-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            $sqlStatement = $connection->prepare("SELECT * FROM Orders WHERE OrderID=?");
            $sqlStatement->bind_param("s", $_GET["OrderID"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $OrderGETExist = $result->num_rows;
            if ($OrderGETExist == 0) {
                print "<script>alert('The order does not exist');</script>";
                print '<script>window.location.href = "orders.php";</script>';
                die();
            }

            $sqlStatement = $connection->prepare("SELECT * FROM AllorderTotal WHERE OrderID=?");
            $sqlStatement->bind_param("s", $_GET["OrderID"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $row = $result->fetch_assoc();
        ?>


            <div class="col bg-white">
                <div class="p-3" style="width: 200px;">
                    <div class="e-navlist e-navlist--active-bg">
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link px-2" href="createProduct.php"><i class="fa fa-plus-square mr-1"></i><span> Create Product</span></a></li>
                            <li class="nav-item"><a class="nav-link px-2" href="orders.php"><i class="fa fa-undo mr-1"></i><span> Go back</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>OrderID</th>
                            <th>User Info</th>
                            <th>Status</th>
                            <th>Order Total</th>
                            <th>Delete</th>
                        </tr>
                    <tbody>
                        <tr>
                            <td>
                                <p class="fw-bold mb-1"><?= $row["OrderID"] ?></p>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="../Images/noIMG.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1"><?= $row["FirstName"] . " " . $row["LastName"] ?></p>
                                        <p class="text-muted mb-0"><?= $row["UserName"] ?></p>
                                        <p class="text-muted mb-0"><?= $row["Email"] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form method="POST" id="changeStatusForm<?= $row["OrderID"] ?>">
                                    <select onchange="document.getElementById('changeStatusForm<?= $row['OrderID'] ?>').submit();" class="form-control w-50" name="OrderStatus" style="color: <?php
                                                                                                                                                                                                if ($row["StatusOrder"] == 0) {
                                                                                                                                                                                                    print "red";
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    print "green";
                                                                                                                                                                                                }
                                                                                                                                                                                                ?>;">
                                        <option <?php if ($row["StatusOrder"] == "0") print "Selected" ?> style="color:red;" value="0">In progress</option>
                                        <option <?php if ($row["StatusOrder"] == "1") print "Selected" ?> style="color:green;" value="1">Done</option>
                                    </select>
                                    <input name="OrderIDStatus" type="text" hidden value="<?= $row['OrderID'] ?>">
                                </form>
                            </td>
                            <td><?= $row["TotalOrder"] ?>€</td>
                            <td>
                                <form method="POST">
                                    <input name="OrderID" type="text" hidden value="<?= $row["OrderID"] ?>">
                                    <input name="GETclear" type="text" hidden>
                                    <button name="deleteOrder" type="submit" class="btn btn-danger btn-sm fw-bold">Delete</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    </thead>
                </table>
            </div>



            <br>

            <?php
            $sqlStatement = $connection->prepare("SELECT * FROM orderTotalperItem WHERE OrderID=?");
            $sqlStatement->bind_param("s", $_GET["OrderID"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();

            ?>

            <div class="table-responsive">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Product Info</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total item price</th>
                            <th>Delete</th>
                        </tr>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td>
                                    <a href="ShowProduct.php?ProductID=<?= $row["ProductsID"] ?>#slider-image-1">
                                        <div class="d-flex align-items-center">
                                            <img src="../Images/<?= $row["ImageLink"] ?>.jpg" alt="<?= $row["ProductNameFull"] ?>" style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1"><?= $row["ProductNameFull"] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <?= $row["Price"] ?>€
                                </td>
                                <td>
                                    <form method="POST" id="quantityOrderChangeForm<?= $row["ProductsID"] ?>">
                                        <div class="form-group col-xs-3">
                                            <input value="<?= $row["QuantityProduct"] ?>" name="quantityOrderChange" type="number" min="1" onblur="document.getElementById('quantityOrderChangeForm<?= $row['ProductsID'] ?>').submit();" onkeyup="runWithEnter(event, 'quantityOrderChangeForm<?= $row['ProductsID'] ?>')">
                                            <input name="ProductsIDquantityOrder" type="text" hidden value="<?= $row["ProductsID"] ?>">
                                        </div>
                                    </form>
                                </td>
                                <td><?= $row["totalperItem"] ?>€</td>
                                <td>
                                    <form method="POST">
                                        <input name="ProductsIDInput" type="text" hidden value="<?= $row["ProductsID"] ?>">
                                        <button name="deleteProductFromOrder" type="submit" class="btn btn-danger btn-sm fw-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
            <br><br>
        <?php
        }
        ?>
    </section>
</body>

</html>