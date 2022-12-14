<?php

$namesRegex = "/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ'`'\-]+$/";

if (isset($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["passwordRepeat"])) {
    /*
if (!firstName) {
        $("#firstName").parent().children("div").html("Please Write something for First Name");
        JSvalidation++;
    } else {
        if (checkNames(firstName) == false) {
            $("#firstName").parent().children("div").html("Please write a name with letters");
            JSvalidation++;
        } else {
            $("#firstName").parent().children("div").html("");
        }
    }



    if (!lastName) {
        $("#lastName").parent().children("div").html("Please Write something for Last Name");
        JSvalidation++;
    } else {
        if (checkNames(lastName) == false) {
            $("#lastName").parent().children("div").html("Please write a name with letters");
            JSvalidation++;
        } else {
            $("#lastName").parent().children("div").html("");
        }
    }
    */

    if (!empty($_POST["firstName"]) || !empty($_POST["lastName"]) || !empty($_POST["email"]) || !empty($_POST["password"]) || !empty($_POST["passwordRepeat"])) {

        if (!preg_match($namesRegex, $_POST["firstName"]) || !preg_match($namesRegex, $_POST["lastName"])) {
            die();
        }
    } else {
        die();
    }
}
