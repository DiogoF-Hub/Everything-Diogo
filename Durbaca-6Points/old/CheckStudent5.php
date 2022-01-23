<?php

$filename = '../testfolder/points.txt';
if(file_exists($filename)){
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) { 
        $arraytest = explode(";", $line);
        $key5 = array_search($arraytest[1], $arrayOfStudents);
        //echo $key5;
        if(isset($key5)){
            array_splice($arrayOfStudents, $key5, 1);
            $key5 = "";
        }
    }
    fclose($handle);
} else {
    die("File not found");
}