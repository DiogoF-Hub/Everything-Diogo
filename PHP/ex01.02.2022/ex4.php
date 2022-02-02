<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .box {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <?php
    $data = ["1" => "blue", "2" => "red", "3" => "green"];

    if (isset($_GET["colorChoice"], $_GET["NoBoxes"])) {
        if (is_numeric($_GET["NoBoxes"]) && (isset($data[$_GET["colorChoice"]]))) {
            for ($i = 1; $i <= $_GET["NoBoxes"]; $i++) { ?>
                <div class="box" style="background-color: <?= $data[$_GET["colorChoice"]]; ?>"><?= $i ?></div>
                <br>
        <?php }
        } else {
            print("Please enter a number");
        }
    } else {
        ?>

        <form method="GET">
            Please choose the box color: <select name="colorChoice">
                <?php foreach ($data as $key => $value) { ?>
                    <option value="<?= $key; ?>"> <?= $value; ?> </option>
                <?php } ?>
            </select>

            <br>

            Please write how many boxes you want: <input type="number" name="NoBoxes">
            <button type="submit">Go</button>
        </form>
    <?php } ?>
</body>

</html>