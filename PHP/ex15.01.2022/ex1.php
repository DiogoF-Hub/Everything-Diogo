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

        <input type="text" name="myinput">
        <button type="submit">Go</button>

    </form>

    <?php
    $result = 0;
    $cal = "";
    if (isset($_POST["myinput"])) {
        for ($i = 1; $i <= $_POST["myinput"]; $i++) {
            $result = $i * ($i + 1) + $result;

            if ($i == $_POST["myinput"]) {
                $cal = $cal . "$i * ($i + 1)";
            } else {
                $cal = $cal . "$i * ($i + 1) + ";
            }
        }
    ?>
        <div><?= $cal ?> = <?= $result ?></div>
    <?php
    }
    ?>
</body>

</html>