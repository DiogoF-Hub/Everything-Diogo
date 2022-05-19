<?php

$host = "localhost";
$user = "root";
$psw = "";
$database = "countries";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

$sqlStatement2 = $connection->prepare("SELECT * from countriesTable");
$sqlStatement2->execute();
$result2 = $sqlStatement2->get_result();


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
    <select name="" id="">
        <option disabled selected value="-1">Select</option>
        <?php
        while ($row = $result2->fetch_assoc()) {
        ?>
            <option value="<?= $row["id"] ?>"><?= $row["countriesName"] ?></option>
        <?php
        }
        ?>
    </select>
</body>

</html>