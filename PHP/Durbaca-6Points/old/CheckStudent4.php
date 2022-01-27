<?php

$filename = '../testfolder/points.txt';
if(file_exists($filename)){
    $handle = fopen($filename, "r");
    while (($line = fgets($handle)) !== false) { 
        $arraytest = explode(";", $line);
        print($arraytest[1]);
        
    }
    fclose($handle);
} else {
    die("File not found");
}


//print_r($arrayOfStudents);

