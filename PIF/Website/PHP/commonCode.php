<?php
include_once("../HTML/commonCodeHTML.php");

header('Content-Type: application/json; charset=utf-8'); //needed for ajax request

$namesRegex = "/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ''\-]+$/";
$emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

function returnRes($data = null) //func to return the result of ajax request
{
    http_response_code(200);
    $object = new stdClass();
    if ($data != null) {
        $object->data = $data;
    }
    echo json_encode($object);
    die();
}

function validateDate($date, $format = 'd-m-Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
