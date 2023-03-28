<?php
$host = "localhost";
$user = "root";
$psw = "";
$database = "bankAccounts";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);
?>


<?php
//Login
if (isset($_GET["User"]) && !isset($_GET["depositAmount"]) && !isset($_GET["withdrawAmount"])) { //If the user is on the Login part. The other issets are used to avoid repeating this login code process after the "#NextActions" buttons are pressed  
    $sqlBalance = $connection->prepare("SELECT Balance FROM ppl WHERE PersonName=?");
    $sqlBalance->bind_param("s", $_GET["User"]); //Get replaced to the PersonName="?"
    $sqlBalance->execute();
    $sqlResult = $sqlBalance->get_result();
    if ($sqlResult->num_rows > 0) { //If the user exists
        $row = $sqlResult->fetch_assoc();
        echo "Balance: " . $row["Balance"];
    } else {
        echo "Unknown user";
    }
}

// Deposit
else if (isset($_GET["User"]) && isset($_GET["depositAmount"])) { //If the user was given and if the deposit button was pressed
    $sqlCheckUser = $connection->prepare("SELECT PersonName FROM ppl WHERE PersonName=?");
    $sqlCheckUser->bind_param("s", $_GET["User"]);
    $sqlCheckUser->execute();
    $result = $sqlCheckUser->get_result();

    if ($result->num_rows > 0) { //If the user exists
        $sqlDeposit = $connection->prepare("UPDATE ppl SET Balance=Balance+? WHERE PersonName=?");
        $sqlDeposit->bind_param("is", $_GET["depositAmount"], $_GET["User"]);
        $sqlDeposit->execute();
        echo "Hopefully, we saved your money. Rest assured that you are safe with us!";
    } else {
        echo "Unknown user";
    }
}

// Withdraw
else if (isset($_GET["User"]) && isset($_GET["withdrawAmount"])) { //If the user was given and if the withdraw button was pressed
    $sqlWithdraw = $connection->prepare("SELECT Balance FROM ppl WHERE PersonName=?");
    $sqlWithdraw->bind_param("s", $_GET["User"]);
    $sqlWithdraw->execute();
    $sqlResult = $sqlWithdraw->get_result();

    if ($sqlResult->num_rows > 0) { //If the user exists
        $row = $sqlResult->fetch_assoc();
        $balance = $row["Balance"];
        if ($balance < $_GET["withdrawAmount"]) { //If the bank account is smaller then the amount the user wants to withdraw
            echo "You can't have that";
        } else {
            $sqlWithdrawSubstr = $connection->prepare("UPDATE ppl SET Balance=Balance-? WHERE PersonName=?");
            $sqlWithdrawSubstr->bind_param("is", $_GET["withdrawAmount"], $_GET["User"]);
            $sqlWithdrawSubstr->execute();
            $sqlResult = $sqlWithdrawSubstr->get_result();
            echo "Your transaction has been recorded!";
        }
    } else {
        echo "Unknown user";
    }
}
?>