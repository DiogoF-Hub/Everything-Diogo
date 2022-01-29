<?php

if (isset($_POST["usernamelogin"], $_POST["passwordlogin"])) {

    $matches = array();

    $handle = @fopen("../database/users.txt", "r");
    if ($handle) {
        while (!feof($handle)) {
            $buffer = fgets($handle);
            if (strpos($buffer, $_POST["usernamelogin"]) !== FALSE) {
                break;
            }
        }
        fclose($handle);
    }

    $arraytest2 = explode(";", $buffer);

    if ($_POST["usernamelogin"] == $arraytest2[0] && $_POST["passwordlogin"] == $arraytest2[1]) {
        session_start();
        $_SESSION["username"] = $arraytest2[0];
        $_SESSION["firstname"] = $arraytest2[2];
        $_SESSION["lastname"] = $arraytest2[3];
    } else {
        print "no";
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <title>Acount page</title>
    <script>
        function checkLogin() {
            err = 0;
            username = document.getElementById("usernamelogin").value;
            password = document.getElementById("passwordlogin").value;

            if (username === "") {
                err++;
                document.getElementById("usernameloginErr").innerHTML = "* Username missing";
            }

            if (password === "") {
                err++;
                document.getElementById("passwordloginErr").innerHTML = "* Password missing";
            }

            if (err == 0) {
                document.getElementById("formLogin").submit();
            }

        }

        function checkSignUp() {
            err2 = 0;
            firstname = document.getElementById("firstnamereg").value;
            lastname = document.getElementById("lastnamereg").value;
            username2 = document.getElementById("usernamereg").value;
            password2 = document.getElementById("passwordreg").value;

            if (firstname === "") {
                err2++;
                document.getElementById("firstnameregErr").innerHTML = "* First name is missing";
            }

            if (lastname === "") {
                err2++;
                document.getElementById("lastnameregErr").innerHTML = "* Last name is missing";
            }

            if (username2 === "") {
                err2++;
                document.getElementById("usernameregErr").innerHTML = "* Username is missing";
            }

            if (password2 === "") {
                err2++;
                document.getElementById("passwordregErr").innerHTML = "* Password is missing";
            }

            if (err2 == 0) {
                document.getElementById("formSignUp").submit();
            }

        }
    </script>
</head>

<body>

    <?php
    include_once("nav.php");
    navbar("HomePT.php", "home", 0, "EN");
    ?>

    <section class="section1">


        <div class="BoxDiv">
            <form method="POST" id="formLogin">

                <h3>Sign In</h3>
                <div>Username:<input type="text" name="usernamelogin" id="usernamelogin"></div>
                <div id="usernameloginErr"></div>
                <br>
                <div>Password:<input type="password" name="passwordlogin" id="passwordlogin"></div>
                <div id="passwordloginErr"></div>


            </form>
            <br>
            <button onclick="checkLogin();">Sign In</button>
        </div>



        <br><br>



        <div class="BoxDiv">
            <form method="POST" id="formSignUp">

                <h3>Sign Up</h3>
                <div>First Name:<input type="text" name="firstnamereg" id="firstnamereg"></div>
                <div id="firstnameregErr"></div>
                <br>
                <div>Last Name:<input type="text" name="lastnamereg" id="lastnamereg"></div>
                <div id="lastnameregErr"></div>
                <br>
                <div>Username:<input type="text" name="usernamereg" id="usernamereg"></div>
                <div id="usernameregErr"></div>
                <br>
                <div>Password:<input type="password" name="passwordreg" id="passwordreg"></div>
                <div id="passwordregErr"></div>


            </form>
            <br>
            <button onclick="checkSignUp();">Sign Up</button>
        </div>


        <?php

        if (isset($_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $_POST["passwordreg"])) {
            $fp = fopen('../database/users.txt', 'a+');

            $newUser =  $_POST["usernamereg"] . ";" . $_POST["passwordreg"] . ";" . $_POST["firstnamereg"] . ";" . $_POST["lastnamereg"] . "\n";
            if (fwrite($fp, $newUser)) {
                echo "saved :)";
            } else {
                echo "Not Saved :(";
            }

            fclose($fp);
        }

        ?>


    </section>

</body>

</html>