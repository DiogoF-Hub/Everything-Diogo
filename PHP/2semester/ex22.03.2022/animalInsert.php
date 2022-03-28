<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    $host = "localhost";
    $user = "root";
    $psw = "";
    $database = "animalsinsert";
    $portnu = 3306;
    $connection = new mysqli($host, $user, $psw, $database, $portnu);

    if (isset($_POST["newAnimal"])) {
        print "You want to insert a " . $_POST["newAnimal"] . " into the database";

        $sqlStatement = $connection->prepare("INSERT INTO Animals(animalName,Continent) VALUES(?,?)");
        $sqlStatement->bind_param("ss", $_POST["newAnimal"], $_POST["Continent"]);

        if (!$sqlStatement->execute()) {
            print "We inserted the animal into the database";
        } else {
            print "We did not insert the animal into the database";
        }
    }

    $sqlStatement = $connection->prepare("SELECT * from animals");
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $numberofanimals = $result->num_rows;

    if ($numberofanimals == 0) {
        print("No animals were found: :(");
    } else {
        while ($row = $result->fetch_assoc()) {
            print $row["AnimalName"] . " lives in " . $row["Continent"] . "<br>";
        }
    }
    ?>
    <form method="post">

        <input name="newAnimal">
        <select name="Continent">
            <option>Europe</option>
            <option>America</option>
            <option>Africa</option>
            <option>Asia</option>
            <option>Antarctica</option>
            <option>Australia</option>
        </select>

        <input type="submit" value="go">
    </form>


    <?php

    ?>
</body>

</html>