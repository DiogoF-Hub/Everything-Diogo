<?php
$txtFile = file_get_contents('..\testfolder\points.txt');

$linesNumber = count(file('..\testfolder\points.txt'));

$studentsDone = [];


$line = explode("\n", $txtFile);
for ($i = 0; $i <= $linesNumber - 1; $i += 8) {


    list($string, $name) = explode(":", $line[$i]);

    array_push($studentsDone, $name);
}

//print_r($studentsDone);

/*if (Count($studentsDone) > 0) {*/
for ($i = 0; $i < Count($studentsDone); $i++) {
    print "<script>arrayOfStudents.splice(" . $i . ", 1);</script>";
    unset($arrayOfStudents[$i]);
    //array_slice($arrayOfStudents, $i);
}
/*}*/


print_r($arrayOfStudents);
