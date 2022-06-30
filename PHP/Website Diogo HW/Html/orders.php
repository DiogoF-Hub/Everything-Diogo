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
?>

<!DOCTYPE html>
<html lang="en">

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
    <title>Orders</title>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("orders.php?lang=" . $otherlang, "user", $sqlLang);
    ?>

    <section class="section1">
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
                $sqlStatement = $connection->prepare("SELECT OrderID, ProfilePic, FirstName, LastName, UserName, Email, StatusOrder, TotalOrder FROM Orders NATURAL JOIN Users");
                $sqlStatement->execute();
                $result = $sqlStatement->get_result();
                $numberOfOrders = $result->num_rows;

                while ($row = $result->fetch_assoc()) {
                ?>
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
                            <span style="color:green;" class="badge-success rounded-pill d-inline"><?= $row["StatusOrder"] ?></span>
                        </td>
                        <td><?= $row["TotalOrder"] ?>€</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm fw-bold">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm fw-bold">Delete</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>