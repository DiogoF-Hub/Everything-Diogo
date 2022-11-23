<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src=""></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $host = "localhost";
    $user = "root";

    $connection = new mysqli($host, $user, "", "countriesandcities");
    $sqlSelect = $connection->prepare("SELECT * from countries");
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    while ($row = $result->fetch_assoc()) {
    ?>
        <option value="<?= $row["CountryID"] ?>"><?= $row["CountryName"] ?></option>
    <?php
    }
    ?>
</body>

</html>