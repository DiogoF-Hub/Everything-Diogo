<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page to create new animals into the db</title>
</head>

<body>

    <?php
    $host = "localhost";
    $user = "root";
    $psw = "";
    $portNo = 3306;
    $dbName = "animalsInsert";
    $connection = new mysqli($host, $user, $psw, $dbName, $portNo);

    mysqli_report(MYSQLI_REPORT_OFF);

    if (isset($_POST["newAnimal"])) {
        //print "You want to insert a ".$_POST["newAnimal"]." into the database";
        $sqlStatement = $connection->prepare("INSERT INTO Animals(AnimalName,Continent) VALUES(?,?)");
        $sqlStatement->bind_param("ss", $_POST["newAnimal"], $_POST["continentOfAnimal"]);
        if (!$sqlStatement->execute()) {
            print "We did NOT insert the animal into the database<br>";
        } else {
            print "We inserted the animal into the database<br>";
        }
    }


    $sqlStatement = $connection->prepare("SELECT * from animals");
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $numberOfAnimals = $result->num_rows;
    if ($numberOfAnimals == 0) {
        print "No animals were found";
    } else {
        while ($row = $result->fetch_assoc()) {
            print $row["AnimalName"] . " lives in " . $row["Continent"] . "<BR>";
        }
    }
    ?>
    <form method="post">
        <input name="newAnimal">
        <select name="continentOfAnimal">
            <option>Europe</option>
            <option>America</option>
            <option>Africa</option>
            <option>Asia</option>
            <option>Antarctica</option>
            <option>Australia</option>
        </select>

        <input type="submit" value="GO">
    </form>




</body>

</html>