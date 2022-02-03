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
        <select name="myselect">
            <option disabled selected>Choose</option>
            <option value="normal">Normal</option>
            <option value="number_asc1">ascending</option>
            <option value="number_desc1">descending</option>
        </select>
        <button type="submit">go</button>
    </form>

    <?php
    $arr = [];
    if (isset($_POST["myselect"])) {

        $filename = 'ex1.txt';
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            array_push($arr, $line);
        }

        if ($_POST["myselect"] == "number_asc1") {
            asort($arr); //ascending
        }

        if ($_POST["myselect"] == "number_desc1") {
            arsort($arr); //descending
        }


        /*for ($i = 0; $i < count($arr); $i++) {
            print  $arr[$i];
            print "<br>";
        }*/

        //MUST use a foreach bcs after arsort or asort the index will keep as they are, so if asort the key will keep the same so if u do a for loop and print from 0 to count($arr) will print as the key is = to and not sorted as u want
        //So using a foreach will print what is inside the arr as it is.    Use print_r so see how the  arr is after arsort or asort, then with this foreach will print on same order whatever is their key
        foreach ($arr as $key => $val) {
            print $val;
            print "<br>";
        }
    }

    ?>
</body>

</html>