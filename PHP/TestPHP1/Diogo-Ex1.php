<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .box {
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        .blueBox {
            background-color: blue;
        }

        .greenBox {
            background-color: green;
        }

        .redBox {
            background-color: red;
        }
    </style>
</head>

<body>
    <?php
    $maxRow = 0;
    $filename = 'db.txt';
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) {
        $arraytest = explode(",", $line);
        if (count($arraytest) == 5) {
            $maxRow = trim($arraytest[2]) + trim($arraytest[3]) + trim($arraytest[4]);
            if (is_numeric($maxRow+$arraytest[0])) {
                if ($maxRow < $arraytest[0]) {
    ?>
                    <div>
                        <?php
                        for ($i = 1; $i <= $maxRow; $i++) {
                        ?>
                            <span class="box <?= trim($arraytest[1]) ?>"></span>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <div>MAX LIMIT reached</div>
    <?php
                }
            }
        }else{
            ?>
                <div>Cannot parse this row</div>
            <?php
        }
    }
    ?>
</body>

</html>