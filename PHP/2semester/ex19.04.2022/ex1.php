<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>User regisatration form.</h1>

    Please fill in the following to signup with our website:

    <?php

    if (isset($_POST["Username"], $_POST["PSW"])) {

        $host = "localhost";

        $user = "root";

        $psw = "";

        $portnu = 3306;

        $database = "shop";



        $connection = new mysqli($host, $user, $psw, $database, $portnu);

        $sqlInsert = $connection->prepare("INSERT INTO Users(UserName,UserPassword) Values(?,?)");

        $sqlInsert->bind_param("ss", $_POST["Username"], $_POST["PSW"]);

        if ($sqlInsert->execute()) {
            print("Welcome");
        } else {
            print("User already exists!");
        }

        print("<h1>Welcome</h1>");
    }

    ?>

    <form method="POST">

        <input type="text" name="Username" placeholder="USER">

        <input type="Password" name="PSW" placeholder="PSW">

        <input type="submit" name="Go" value="Register">

    </form>
</body>

</html>