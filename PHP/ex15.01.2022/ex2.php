<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .box {
            height: 50px;
            width: 50px;
            border: black 1px solid;
        }

        .blue {
            background-color: blue;
        }

        .red {
            background-color: red;
        }

        .yellow {
            background-color: yellow;
        }
    </style>
</head>

<body>

    <?php

    $filename = 'ex2.txt';
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) {
        $arraytest = explode(";", $line);
        for ($i = 1; $i <= $arraytest[0]; $i++) {
    ?>
            <div class="box <?= $arraytest[1] ?>"><?= $i ?></div>
        <?php
        }
        ?>
        <br>
    <?php
    }

    ?>

</body>

</html>