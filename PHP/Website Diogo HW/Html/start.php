<?php
session_start();
if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "EN";
}


$langs = ["EN", "PT"];
$otherlang = "PT";
$togle = 0;
$IDlang = 1;

if (isset($_GET["lang"])) {
    if (!in_array($_GET["lang"], $langs)) {
        $_GET["lang"] = "EN";
    }

    $_SESSION["lang"] = $_GET["lang"];

    if ($_GET["lang"] == "PT") {
        $otherlang = "EN";
        $togle = 5;
        $IDlang = 2;
    }
}

print($_SESSION["lang"]);
