<?php

$filename = 'points.txt';
if (file_exists($filename)) {
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) {
        $arraytest = explode(";", $line);
        $key5 = array_search($arraytest[1], $arrayOfStudents);
        if ($key5 !== false) {
            array_splice($arrayOfStudents, $key5, 1);
            print("<script>array.splice(" . $key5 . ", 1);</script>");
        }
    }
    fclose($handle);
} else {
    die("File not found");
}
