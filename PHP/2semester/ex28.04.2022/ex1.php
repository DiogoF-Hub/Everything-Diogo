<?php
session_start();

if (!isset($_SESSION["UserIn"])) {
    $_SESSION["UserIn"] = false;
}
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
    <?php
    if (isset($_POST["login"])) {
        $_SESSION["UserIn"] = true;
    }

    if (isset($_POST["logout"])) {
        $_SESSION["UserIn"] = false;
    }

    if ($_SESSION["UserIn"]) {
    ?>
        <form method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    <?php
    } else {
    ?>
        <form method="POST">
            <button type="submit" name="login">Login</button>
        </form>
    <?php
    }
    ?>
</body>

</html>