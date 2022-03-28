<?php
session_start();
if (!isset($_SESSION["userIsLoggedIn"])) {
    $_SESSION["userIsLoggedIn"] = false;
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
        $_SESSION["userIsLoggedIn"] = true;
    }

    if (isset($_POST["logout"])) {
        $_SESSION["userIsLoggedIn"] = false;
    }

    if ($_SESSION["userIsLoggedIn"]) {
    ?>
        <form method="POST">
            <button type="submit" name="logout">logout</button>
        </form>
    <?php
    } else {
    ?>
        <form method="POST">
            <button type="submit" name="login">login</button>
        </form>
    <?php
    }
    ?>
    <div>This is a page with session !!</div>


</body>

</html>