<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Form</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("FormPT.php", "form", 0, "EN");
    ?>


    <section class="section1">

        <div class="divform">
            <form action="EndEN.php" id="flex1">
                <label class="label1">First name:</label>
                <input>
                <label class="label1">Last name:</label>
                <input>
                <label class="label1">Birthday:</label>
                <input type="date">
                <label class="label1">Email:</label>
                <input>
                <label class="label1">Adress:</label>
                <input placeholder="Adress line 1">
                <input placeholder="Adress line 2 (optional)">
                <input placeholder="Post code">
                <input placeholder="City">
                <input placeholder="Country">
                <label class="label1">CV and LM</label>
                <input type="file" accept=".docx, .pdf, .doc" multiple>
                <div>----</div>
                <input type="submit" value="Submit" id="submit">
            </form>
        </div>
    </section>
</body>

</html>