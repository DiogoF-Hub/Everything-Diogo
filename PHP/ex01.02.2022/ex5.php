<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST">
        i<input type="number" name="myinput1">
        <br>
        n<input type="number" name="myinput2">
        <br>
        <button type="submit">Go</button>
    </form>

    <?php
    $result = 0;
    $cal = "";
    if (isset($_POST["myinput1"], $_POST["myinput2"])) {
        for ($i = $_POST["myinput1"]; $i <= $_POST["myinput2"]; $i++) {

            $result += $i * ($i + 1);

            if ($i < $_POST["myinput2"]) {
                $cal = $cal . "$i * ($i + 1) + ";
            } else {
                $cal = $cal . "$i * ($i + 1)";
            }
        }

        print $cal . " = " . $result;
    }
    ?>
</body>

</html>