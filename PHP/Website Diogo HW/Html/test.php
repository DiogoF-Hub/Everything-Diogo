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
    ?>
</body>

</html>