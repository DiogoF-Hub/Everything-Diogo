<?php
session_start();
if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "EN";
}

$langs = ["EN", "PT"];

if (isset($_GET["lang"])) {
    if (!in_array($_GET["lang"], $langs)) {
        $_GET["lang"] = "EN";
    }

    $_SESSION["lang"] = $_GET["lang"];
}



if ($_SESSION["lang"] == "EN") {
    $otherlang = "PT";
    $togle = 0;
    $IDlang = 1;
} else {
    $otherlang = "EN";
    $togle = 5;
    $IDlang = 2;
}
