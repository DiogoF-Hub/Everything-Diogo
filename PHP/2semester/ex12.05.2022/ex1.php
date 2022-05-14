<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        h1 {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .OneProduct {
            font-size: 12px;
            width: 100px;
            height: 100px;
            background-color: bisque;
            margin: 10px;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php
    include_once("ex1 common code.php");

    if (isset($_POST["BuyProduct"])) {
        if (isset($_SESSION["ShoppingCart"][$_POST["BuyProduct"]])) {
            $_SESSION["ShoppingCart"][$_POST["BuyProduct"]]++;
        } else {
            $_SESSION["ShoppingCart"][$_POST["BuyProduct"]] = 1;
        }
    }
    ?>


    <h1>

        <?php
        $sqlProducts = $connection->prepare("SELECT * from Products");
        $sqlProducts->execute();
        $result = $sqlProducts->get_result();

        while ($row = $result->fetch_assoc()) {
        ?>

            <div class="OneProduct">
                Name: <?= $row["ProductName"] ?>
                Description: <?= $row["ProductDesc"] ?>
                Price: <?= $row["ProductPrice"] ?>

                <form method="POST">
                    <input hidden type="text" name="BuyProduct" value="<?= $row["ProductId"] ?>">
                    <button type="submit">Buy</button>
                </form>
            </div>

        <?php
        }



        ?>

    </h1>

</body>

</html>