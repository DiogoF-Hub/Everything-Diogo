<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" id="myform">
        <select name="myselect">
            <option value="asc">ascending</option>
            <option value="desc">descending</option>
        </select>
        <button type="submit">go</button>
    </form>
    <?php
    $arr = [];
    if (isset($_POST["myselect"])) {
        $filename = 'ex1.txt';
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            $arraytest = explode(";", $line);
            array_push($arr, $arraytest[0]);
        }

        if ($_POST["myselect"] == "asc") {
            asort($arr);
        }

        if ($_POST["myselect"] == "desc") {
            arsort($arr);
        }

        print_r($arr);

        for ($i = 0; $i <= count($arr) - 1; $i++) {
    ?>
            <div>
                <?= $arr[$i] ?>
            </div>
    <?php
        }
    }

    ?>
</body>

</html>