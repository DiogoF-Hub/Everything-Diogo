<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>About</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
</head>

<body>
    <?php

    $langs = ["EN", "PT"];
    $otherlang = "PT";
    $togle = 0;

    if (isset($_GET["lang"])) {
        if (!in_array($_GET["lang"], $langs)) {
            $_GET["lang"] = "EN";
        }

        if ($_GET["lang"] == "PT") {
            $otherlang = "EN";
            $togle = 5;
        }
    } else {
        $_GET["lang"] = "EN";
    }

    include_once("nav.php");
    navbar("About.php?lang=" . $otherlang, "about", $togle, $_GET["lang"]);
    ?>

    <section class="section1">

        <div class="divAbout">
            <a href="https://fr.wikipedia.org/wiki/Groupe_LDLC" target="_blank">
                <img src="../Images/Group%20LDLC.PNG" alt="Group LDLC">
            </a>

            <div>-The LDLC Group is a French online business group, created in 1996 by Laurent de la Clergerie.</div>
            <div>-It was ranked 5th in France by FEVAD in 2016.</div>
            <div>-Its major brand, LDLC.com, is positioned as a major player in online IT and high-tech commerce in France.</div>
            <div>-Composed of multiple brands including five merchant sites,</div>
            <div>this business combination combines activities in the field of IT, high-tech or education.</div>
            <div>----</div>
            <div>-In addition to the characteristics common to most online sales sites</div>
            <div>(top sales by category, online product reviews, etc.), the site quickly</div>
            <div>set up a faceted search to facilitate the search for products such as</div>
            <div>motherboards, RAMs or monitors whose offer is sometimes in the hundreds of models.</div>
            <div>-The site also has the particularity of offering computers delivered without</div>
            <div>a pre-installed operating system.</div>
        </div>
    </section>
</body>

</html>