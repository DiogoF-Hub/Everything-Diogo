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

    $arr = [];
    $arr["peppa"] = "pig";
    print_r($arr);
    print "<br>";
    print $arr["peppa"];

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
            <th>Amount</th>
        </tr>

        <?php

        foreach ($carsArr as $name => $amount) {
        ?>
            <tr>
                <td><?= $name ?></td>
                <td><?= $amount ?></td>
            </tr>
        <?php
            $totalcars += $amount;
        }

        ?>

        <tr>
            <th>TOTAL:</th>
            <th><?= $totalcars ?></th>
        </tr>

    </table>

</body>

</html>