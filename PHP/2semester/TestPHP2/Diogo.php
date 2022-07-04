<?php
session_start();

$host = "localhost";
$user = "root";
$psw = "";
$database = "Wsers2";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

if (isset($_POST["CityId"], $_POST["Inhabitants"])) {
    $sqlStatement = $connection->prepare("UPDATE Cities SET Inhabitants=? WHERE CityId=?");
    $sqlStatement->bind_param("ii", $_POST["Inhabitants"], $_POST["CityId"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Wsers2</title>
</head>

<body>
    <?php
    if (isset($_POST["countriesSelect"])) {
        if ($_POST["countriesSelect"] != "-1") {
            $_SESSION["countriesSelect"] = $_POST["countriesSelect"];

            $sqlStatement = $connection->prepare("SELECT * from Countries WHERE CountryID=?");
            $sqlStatement->bind_param("i", $_SESSION["countriesSelect"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();

            if ($result->num_rows == 0) {
                print "Bad user";
                die();
            }
        } else {
            unset($_SESSION["countriesSelect"]);
        }
    }
    ?>

    <form method="POST">
        <select name="countriesSelect">
            <option value="-1">No country</option>
            <?php
            $sqlStatement = $connection->prepare("SELECT * from Countries");
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();

            while ($row = $result->fetch_assoc()) {
            ?>
                <option <?php if (isset($_SESSION["countriesSelect"]) && $_SESSION["countriesSelect"] == $row["CountryID"]) print "Selected" ?> value="<?= $row["CountryID"] ?>"><?= $row["CountryName"] ?></option>
            <?php
            }
            ?>
        </select>
        <button type="submit">Show Cities</button>
    </form>

    <?php
    if (!isset($_SESSION["countriesSelect"])) {
        print "Please choose a country";
    } else {
    ?>
        <form method="POST">
            <input name="filter" type="text" placeholder="Filter max inhabitants">
            <button type="submit">Filter</button>
        </form>

        <table>
            <tr>
                <th>City</th>
                <th>Population</th>
            </tr>


            <?php
            if (!isset($_POST["filter"])) {
                $sqlStatement = $connection->prepare("Select * from Countries natural join Cities WHERE CountryID=?");
                $sqlStatement->bind_param("i", $_SESSION["countriesSelect"]);
            } else {
                $sqlStatement = $connection->prepare("Select * from Countries natural join Cities WHERE CountryID=? AND Inhabitants<?");
                $sqlStatement->bind_param("ii", $_SESSION["countriesSelect"], $_POST["filter"]);
            }


            $sqlStatement->execute();
            $result = $sqlStatement->get_result();

            $totalppl = 0;
            while ($row = $result->fetch_assoc()) {
                $totalppl = $totalppl + $row["Inhabitants"];
            ?>
                <tr>
                    <td><?= $row["CityName"] ?></td>
                    <td>
                        <form method="POST"> <input type="text" name="CityId" value="<?= $row["CityId"] ?>" hidden> <input name="Inhabitants" type="number" value="<?= $row["Inhabitants"] ?>"><button type="submit">Save</button></form>
                    </td>
                </tr>
            <?php

            }
            ?>
        </table>

        <h1>Ppl living in the selected country: <?= $totalppl ?></h1>
    <?php
    }
    ?>


</body>

</html>