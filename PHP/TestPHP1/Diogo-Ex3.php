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
    $result = 0;
    $cal = "";
    if (isset($_POST["myselect"], $_POST["n"], $_POST["start"])) {
        if ($_POST["start"] < $_POST["n"] - 1) {
            if ($_POST["myselect"] == 1) {
                for ($i = $_POST["start"]; $i <= $_POST["n"] - 1; $i++) {
                    $result += (int)(($i - 2) * ($i + 3));
                    if ($i == $_POST["n"] - 1) {
                        $cal = $cal . "($i - 2) * ($i + 3)";
                    } else {
                        $cal = $cal . "($i - 2) * ($i + 3) + ";
                    }
                }
            } else {
                for ($i = $_POST["n"] - 1; $i >= $_POST["start"]; $i--) {
                    $result += (($i - 2) * ($i + 3));
                    if ($i == $_POST["start"]) {
                        $cal = $cal . "($i - 2) * ($i + 3)";
                    } else {
                        $cal = $cal . "($i - 2) * ($i + 3) + ";
                    }
                }
            }
            print $cal . " = " . $result;

            //Ex3

            $text = $cal . " = " . $result . ";". "\n";
            $fp = fopen('history.txt', 'a+');
            fwrite($fp, $text);
            fclose($fp);

        } else {
    ?>
            <div>Wrong input</div>
        <?php
        }
    } else {
        ?>
        <form method="POST">
            <select name="myselect">
                <option value="1">Display and compute sum</option>
                <option value="2">Display reversed sum and compute it</option>
            </select>
            <br>
            <div>n<input name="n" type="number"></div>
            <br>
            <div>Start Value<input name="start" type="number"></div>
            <br>
            <button type="submit">DO</button>
        </form>
        <?php 
        $filename = 'history.txt';
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            $arraytest = explode(";", $line);
            print $arraytest[0];
            print "<br>";
        }
        ?>
    <?php } ?>
</body>

</html>