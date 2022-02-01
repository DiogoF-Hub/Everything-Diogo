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
            <option value="<"> smaller </option>
            <option value=">"> bigger </option>
        </select>

        <div>than</div>
        <input type="text" name="myinput">
        <button type="submit">Go</button>
    </form>

    <?php
    if (isset($_POST["myselect"], $_POST["myinput"])) {
        $filename = 'ex1.txt';
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            if ($_POST["myselect"] == "<") {
                if ($line < $_POST["myinput"]) {
                    print $line;
                }
            }

            if ($_POST["myselect"] == ">") {
                if ($line > $_POST["myinput"]) {
                    print $line;
                }
            }
        }
    }
    ?>
</body>

</html>