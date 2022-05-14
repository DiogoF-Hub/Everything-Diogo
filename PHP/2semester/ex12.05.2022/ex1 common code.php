<?php
session_start();


if (!isset($_SESSION["UserLoggedIn"])) {
    $_SESSION["UserLoggedIn"] = false;
}


$host = "localhost";
$user = "root";
$psw = "";
$database = "Shop";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);


if (isset($_POST["User"])) {
    $sqlSearchUser = $connection->prepare("SELECT * from USERS WHERE UserName=?");
    $sqlSearchUser->bind_param("s", $_POST["User"]);
    $sqlSearchUser->execute();
    $result = $sqlSearchUser->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["UserLoggedIn"] = true;
        $_SESSION["ShoppingCart"] = [];
        $_SESSION["User"] = $_POST["User"];
    } else {
        print("Your name is not in our DB");
    }
}


if (isset($_POST["Logout"])) {
    session_unset();
    session_destroy();
    header("Refresh:0");
    die();
}


if ($_SESSION["UserLoggedIn"]) {

    print("Welcome " . $_SESSION["User"]);
?>

    <form method="POST">
        <button name="Logout" type="submit">Logout</button>
    </form>

<?php
} else {
?>

    <form method="POST">
        <input type="text" name="User">
        <button name="Login" type="submit">Login</button>
    </form>

<?php
}
?>