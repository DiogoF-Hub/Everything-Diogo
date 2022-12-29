<?php
include_once("../HTML/commonCodeHTML.php");

header('Content-Type: application/json; charset=utf-8');

/*$codes = [
    "Success" => 200,
    "NotFound" => 404,
    "Created" => 201,
    "Forbidden" => 403,
    "BadRequest" => 400
];*/

function returnRes($data = null)
{
    //global $codes;
    http_response_code(200);
    $object = new stdClass();
    if ($data != null) {
        $object->data = $data;
    }
    echo json_encode($object);
    die();
}
