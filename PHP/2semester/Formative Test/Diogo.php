<?php

session_start();

$host = "localhost";
$user = "root";
$psw = "";
$database = "promos";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

if (!isset($_SESSION["UserLoggedIn"])) {
    $_SESSION["UserLoggedIn"] = false;
}

if (isset($_POST["username"])) {
    $_SESSION["UserLoggedIn"] = true;
    $_SESSION["CurrentUser"] = $_POST["username"];

    $sqlStatement2 = $connection->prepare("SELECT * from PPL WHERE UsrName=?");
    $sqlStatement2->bind_param("s", $_POST["username"]);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();

    $userexists2 = $result2->num_rows;

    if ($userexists2 == 0) {
        $sqlStatement3 = $connection->prepare("INSERT INTO PPL(UsrName, Money) Values(?, 0)");
        $sqlStatement3->bind_param("s", $_POST["username"]);
        $sqlStatement3->execute();
        $_SESSION["Money"] = 0;
    } else {
        $row = $result2->fetch_assoc();
        $_SESSION["Money"] = $row["Money"];
    }
}


if (isset($_POST["promoCode"])) {
    $sqlStatement4 = $connection->prepare("SELECT * from promoTable WHERE KeyWord=?");
    $sqlStatement4->bind_param("s", $_POST["promoCode"]);
    $sqlStatement4->execute();
    $result3 = $sqlStatement4->get_result();
    $promoexist = $result3->num_rows;
    $row = $result3->fetch_assoc();


    if ($promoexist == 0) {
        print("This is NOT a valid promotional code.");
    } else {
        if ($row["Available"] == 0) {
            print("You just missed our promotion");
        } else {
            $_SESSION["Money"] = $_SESSION["Money"] + $row["Amount"];
            $row["Available"]--;

            $sqlStatement5 = $connection->prepare("UPDATE promoTable SET Available=? WHERE KeyWord=?");
            $sqlStatement5->bind_param("ss", $row["Available"], $_POST["promoCode"]);
            $sqlStatement5->execute();
        }
    }
}


if (isset($_POST["logout"])) {
    $sqlStatement6 = $connection->prepare("UPDATE PPL SET Money=? WHERE UsrName=?");
    $sqlStatement6->bind_param("ss", $_SESSION["Money"], $_SESSION["CurrentUser"]);
    $sqlStatement6->execute();
    $_SESSION["UserLoggedIn"] = false;
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if ($_SESSION["UserLoggedIn"]) {
    ?>

        <h1>Welcome, <?= $_SESSION["CurrentUser"] ?></h1>
        <h2>You have: <?= $_SESSION["Money"] ?> in your balance</h2>

        <form method="POST">
            <input type="text" name="promoCode" placeholder="promoCode">
            <button type="submit">Try promocode</button>
        </form>

        <br><br>

        <form method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>

    <?php
    } else {
    ?>
        <form method="POST">
            <input type="text" name="username" placeholder="username">
            <button type="submit">Login</button>
        </form>

    <?php
    }
    ?>
</body>

</html>