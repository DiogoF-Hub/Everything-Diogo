<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="GET">

        <select name="myselect">
            <?php
            $arr = ["2" => "Italy", "1" => "France", "3" => "Germany", "6" => "Luxembourg"];

            foreach ($arr as $value => $name) {

            ?>
                <option value="<?= $value ?>"><?= $name ?></option>
            <?php

            }


            ?>
        </select>


        <button type="submit">Go</button>
    </form>

    <?php

    if (isset($_GET["myselect"])) {
        if (!isset($arr[$_GET["myselect"]])) {
            die("You are hacking");
        } else {
            print $arr[$_GET["myselect"]];
        }
    }

    ?>
</body>

</html>