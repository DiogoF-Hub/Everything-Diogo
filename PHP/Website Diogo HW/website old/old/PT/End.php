<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Form submited</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("FormPT.php", "form", 5, "EN");
    ?>

    <div class="divEnd">
        <h1><span class="blueSpan">Your request has been successfully submitted</span></h1>
        <a href="HomeEN.php">
            <h2><span class="blueGreenSpan">Go back</span></h2>
        </a>

    </div>

</body>

</html>