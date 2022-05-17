<?php
$host = "localhost";
$user = "root";
$psw = "";
$database = "Cart";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

$sqlStatement = $connection->prepare("SELECT * from Shop");
$sqlStatement->execute();
$result = $sqlStatement->get_result();


$arrPrices = [];
$totalOrder = 0;
$total = 0;
$resultMulti = 0;

$shopCart = [2 => 4, 4 => 6, 5 => 4, 7 => 2, 10 => 1, 8 => 50];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }

        .blue {
            background-color: blue;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Price</th>
            <th class="blue">Order</th>
            <th class="green">Total each product</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            array_push($arrPrices, $row["Price"]);
            $resultMulti = 0;
        ?>
            <tr>
                <td><?= $row["PriceID"] ?></td>
                <td><?= $row["Price"] ?>€</td>
                <td><?php if (isset($shopCart[$row["PriceID"]])) {
                    ?>
                        <div class="blue">
                            <?php
                            print " * " . $shopCart[$row["PriceID"]];
                            $resultMulti = $shopCart[$row["PriceID"]] * $row["Price"];
                            $totalOrder = $totalOrder + $resultMulti;
                            ?>
                        </div>
                    <?php
                    } else {
                        print "/";
                    } ?>
                </td>
                <td class="green"><?php if ($resultMulti == 0) {
                                        print "/";
                                    } else {
                                        print $resultMulti;
                                    } ?></td>
            </tr>
        <?php
        }

        /*foreach ($shopCart as $key => $value) {
            $sqlStatement2 = $connection->prepare("SELECT * from Shop WHERE PriceID=?");
            $sqlStatement2->bind_param("s", $key);
            $sqlStatement2->execute();
            $result2 = $sqlStatement2->get_result();

            $row2 = $result2->fetch_assoc();


            $totalOrder = $totalOrder + ($row2["Price"] * $value);
        }*/

        for ($i = 0; $i < count($arrPrices); $i++) {
            $total = $total + $arrPrices[$i];
        }
        ?>
        <tr class="red">
            <th>Total 1* each product</th>
            <td><?= $total ?></td>
        </tr>

        <tr class="green">
            <th>Order Total</th>
            <td>=</td>
            <td>=</td>
            <td><?= $totalOrder ?></td>
        </tr>
    </table>

    <br><br>

    <?php
    print_r($shopCart);
    ?>
</body>

</html>