<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function alert2() {
            DateOfBirth = document.getElementById("DateOfBirth").value;
            alert(DateOfBirth);
        }
    </script>
    <script></script>
</head>

<body>
    <input id="DateOfBirth" class="form-control" type="date" value="">
    <button onclick="alert2();">go</button>

    <?php
    echo "<script>alert('" . date("d-m-Y") . "');</script>";

    if (isset($_POST["mybutton"])) {
        $alert = "";

        if (!empty($_POST["1"])) {
            $alert = $alert . " 1,";
        }

        if (!empty($_POST["2"])) {
            $alert = $alert . " 2,";
        }

        if (!empty($_POST["3"])) {
            $alert = $alert . " 3,";
        }

        if (!empty($_POST["4"])) {
            $alert = $alert . " 4,";
        }

        echo "<script>alert('You wrote somethin on " . $alert . "');</script>";
    }
    ?>

    <br><br>

    <form method="POST">
        <input type="text" placeholder="1" name="1"><br>
        <input type="text" placeholder="2" name="2"><br>
        <input type="text" placeholder="3" name="3"><br>
        <input type="text" placeholder="4" name="4"><br>
        <button type="submit" name="mybutton">Go</button>
    </form>
</body>

</html>