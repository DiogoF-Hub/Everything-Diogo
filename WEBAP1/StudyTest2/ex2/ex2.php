<?php
$host = "localhost";
$user = "root";
$psw = "";
$database = "ex2DataBase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

$arrOptions = [];


if (isset($_POST["GetOptions"])) {
    $sqlGetOptions = $connection->prepare("SELECT * FROM TableSaves");
    $sqlGetOptions->execute();
    $result = $sqlGetOptions->get_result();
    while ($row = $result->fetch_assoc()) {
        $arrunserialized = unserialize($row["TableArr"]);

        $save = new stdClass();
        $save->id = $row["TableSaves_id"];
        $save->arr = $arrunserialized;
        array_push($arrOptions, $save);
    }

    echo json_encode($arrOptions);
}


if (isset($_POST["saveArr"])) {
    $arrToSave = json_decode($_POST["saveArr"]);
    $arrToSaveSerialized = serialize($arrToSave);

    $sqlInsert = $connection->prepare("INSERT INTO TableSaves (`TableArr`) VALUES (?)");
    $sqlInsert->bind_param("s", $arrToSaveSerialized);
    $sqlInsert->execute();
}



if (isset($_POST["getSaveGame"])) {
    $sqlGetSaveGame = $connection->prepare("SELECT * FROM TableSaves WHERE TableSaves_id=?");
    $sqlGetSaveGame->bind_param("s", $_POST["getSaveGame"]);
    $sqlGetSaveGame->execute();
    $result = $sqlGetSaveGame->get_result();

    $row = $result->fetch_assoc();

    $arrunserialized = unserialize($row["TableArr"]);

    echo json_encode($arrunserialized);
}
