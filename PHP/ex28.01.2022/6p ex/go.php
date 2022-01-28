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

    $filename = 'file.txt';
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) {
    ?>
        <p><?= $line ?></p>
    <?php
    }

    ?>

    <form method="POST">

        <input type="text" name="myinput">

        <button type="submit">Go</button>

    </form>

    <?php

    if (isset($_POST["myinput"])) {
        $fp = fopen('file.txt', 'a+');
        $text = $_POST["myinput"] . "\n";
        fwrite($fp, $text);
        fclose($fp);
        header("Refresh:0");
    }

    ?>

</body>

</html>