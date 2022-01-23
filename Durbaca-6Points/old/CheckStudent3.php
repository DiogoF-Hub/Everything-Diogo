<?php
$txtFile = file_get_contents('..\testfolder\points.txt');

$linesNumber = count(file('..\testfolder\points.txt'));

$studentsDone = [];


$line = explode("\n", $txtFile);

for ($i = 0; $i <= $linesNumber - 1; $i += 8) {


    list($string, $name) = explode(":", $line[$i]);
    //print $name . ", ";

    array_push($studentsDone, $name);

    //unset($arrayOfStudents[$name]);
}

//print_r($studentsDone);

if (Count($studentsDone) > 0) {
    for ($i = 0; $i < Count($studentsDone) - 1; $i++) {
        //unset($arrayOfStudents[$i]);
        //print "<script>arrayOfStudentsDone.push('" . $studentsDone . "');</script>";
        //array_slice($arrayOfStudents, $i);

        if (($key654 = array_search($name, $studentsDone)) !== false) {
            unset($arrayOfStudents[$key654]);
        }
    }
}

//print "<script>arrayOfStudents.splice(" . $i . ", 1);</script>";

print_r($arrayOfStudents);
