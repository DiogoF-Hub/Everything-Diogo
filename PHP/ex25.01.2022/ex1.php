<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Losch</title>
    <style>
        table,
        th,
        td {
            border: black 1px solid;
        }
    </style>
</head>

<body>

    <?php

    $totalcars = 0;

    $carsArr = [];

    $filename = 'losch.txt';
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) {
        $arraytest = explode(";", $line);
        if (count($arraytest) > 1) {
            if (array_key_exists($arraytest[0], $carsArr) == false) {
                $carsArr[$arraytest[0]] = $arraytest[1];
            } else {
                $carsArr[$arraytest[0]] += $arraytest[1];
            }
        }
    }


    ?>

    <table>

        <tr>
            <th>Name</th>
            <th>Count</th>
        </tr>

        <?php

        foreach ($carsArr as $name => $count) {
        ?>
            <tr>
                <td><?= $name ?></td>
                <td><?= $count ?></td>
            </tr>
        <?php
            $totalcars += $count;
        }

        ?>

    </table>

    <br>

    <div>The total amount of cars is <?= $totalcars ?></div>

    <br><br>

    <?php

    $mycarsArr2 = [];
    $handle2 = fopen($filename, "r");
    while (($line2 = fgets($handle2)) !== false) {
        $arraytest2 = explode(";", $line2);
        if ($arraytest2 < 1) {
        }
    }

    ?>

</body>

</html>