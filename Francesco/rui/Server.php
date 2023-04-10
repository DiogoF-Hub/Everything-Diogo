<?php

$host = "localhost";
$user = "root";
$psw = "";
$database = "bankAccounts";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);

$Response = new stdClass();

if (isset($_GET["user"], $_GET["action"], $_GET["amount"])) {
    $sqlSelectUserData = $connection->prepare("SELECT * FROM ppl WHERE PersonName=?");
    $sqlSelectUserData->bind_param("s", $_GET["user"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();

    $userExists = $result->num_rows;

    if ($userExists > 0) {
        $row = $result->fetch_assoc();

        $NewBalance = $row["Balance"];

        if ($_GET["action"] == "Deposit") { //Deposit
            $NewBalance = $row["Balance"] + $_GET["amount"];
            $Response->Message = "Hopefully, we saved your money. Rest assured that you are safe with us!";
        } else {
            //Withdraw
            if ($row["Balance"] >= $_GET["amount"]) {
                $NewBalance = $row["Balance"] - $_GET["amount"];
                $Response->Message = "Your transaction has been recorded!";
            } else {
                $Response->Message = "You can’t have that";
            }
        }
    } else {
        $Response->Message = "User not found";
    }

    $sqlUpdateUserData = $connection->prepare("UPDATE ppl SET Balance=? WHERE PersonName=?");
    $sqlUpdateUserData->bind_param("ss", $NewBalance, $_GET["user"]);
    $sqlUpdateUserData->execute();

    $Response->Balance = $NewBalance;

    echo json_encode($Response);
    die();
}


if (isset($_GET["userLogin"])) {
    $sqlSelectUserData = $connection->prepare("SELECT * FROM ppl WHERE PersonName=?");
    $sqlSelectUserData->bind_param("s", $_GET["userLogin"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();

    $userExists = $result->num_rows;

    if ($userExists > 0) {
        $row = $result->fetch_assoc();

        $Response->Message = "User found";
        $Response->Balance = $row["Balance"];
    } else {
        $Response->Message = "User not found";
    }

    echo json_encode($Response);
    die();
}
