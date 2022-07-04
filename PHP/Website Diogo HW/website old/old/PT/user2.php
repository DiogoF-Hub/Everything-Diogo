<?php
include_once("start.php");
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <title>Acount page</title>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("user.php?lang=" . $otherlang, "logbutton", $togle);
    ?>
    <section class="section1">
        <h1>User page</h1>
    </section>
</body>

</html>