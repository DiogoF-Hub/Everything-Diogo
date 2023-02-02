<?php
$host = "localhost";
$user = "root";
$psw = "";
$database = "examCities";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

$arrOptions = [];


if (isset($_POST["GetOptions"])) {
    $sqlGetOptions = $connection->prepare("SELECT * FROM Cities");
    $sqlGetOptions->execute();
    $result = $sqlGetOptions->get_result();
    while ($row = $result->fetch_assoc()) {
        array_push($arrOptions, $row["cityName"]);
    }

    echo json_encode($arrOptions);
}



if (isset($_POST["saveCity"])) {
    $response = new stdClass();

    if (empty($_POST["saveCity"])) {
        $response->id = "3";
        echo json_encode($response);
        die();
    }

    $sqlCheck = $connection->prepare("SELECT * FROM Cities WHERE cityName=?");
    $sqlCheck->bind_param("s", $_POST["saveCity"]);
    $sqlCheck->execute();
    $result = $sqlCheck->get_result();
    $rowsNumber = $result->num_rows;

    if ($rowsNumber == 0) {
        $sqlInsert = $connection->prepare("INSERT INTO Cities(cityName) VALUES(?)");
        $sqlInsert->bind_param("s", $_POST["saveCity"]);
        $sqlInsert->execute();

        $response->id = "1";
        echo json_encode($response);
    } else {
        $response->id = "2";
        echo json_encode($response);
    }
}


if (isset($_POST["deleteCity"])) {
    $sqlDelete = $connection->prepare("DELETE FROM Cities WHERE cityName=?");
    $sqlDelete->bind_param("s", $_POST["deleteCity"]);
    $sqlDelete->execute();
}
