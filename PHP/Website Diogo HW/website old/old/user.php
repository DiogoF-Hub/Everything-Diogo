<?php

$toggle = 0;
$wrongUser = 0;
$UserFound = 0;

session_start();

if (isset($_GET["lang"])) {
    if (in_array($_GET["lang"], array("EN", "PT"))) {
        if ($_GET["lang"] == "EN") {
            $otherlang = "PT";
        } else {
            $otherlang = "EN";
            $toggle = 5;
        }
    } else {
        $otherlang = "PT";
        $_GET["lang"] = "EN";
        $toggle = 0;
    }
} else {
    $otherlang = "PT";
    $_GET["lang"] = "EN";
    $toggle = 0;
}



if (isset($_POST["usernamelogin"], $_POST["passwordlogin"])) {

    //this code here is searching for the user
    $handle = @fopen("../database/users.txt", "r");
    if ($handle) {
        while (!feof($handle)) {
            $buffer = fgets($handle);
            if (strpos($buffer, $_POST["usernamelogin"]) !== FALSE) {
                //break; //if it finds, I want him to stop

                $arraytest2 = explode(";", $buffer); //explode the result and then compare to what was written inside the inputs

                if ($_POST["usernamelogin"] == $arraytest2[0] && $_POST["passwordlogin"] == $arraytest2[1]) {
                    //echo "loged in :)";
                    $_SESSION["username"] = $arraytest2[0];
                    $_SESSION["firstname"] = $arraytest2[2];
                    $_SESSION["lastname"] = $arraytest2[3];
                    echo '<script>window.location.href="Home' . $_GET["lang"] . '.php"</script>'; //This will redirect me to home to whatever language im in
                } else {
                    $wrongUser = 1;
                }
            }
        }
        fclose($handle);
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
        lang = "<?= $_GET["lang"] ?>";
        //js validation for login
        function checkLogin() {
            err = 0;
            username = document.getElementById("usernamelogin").value;
            password = document.getElementById("passwordlogin").value;

            if (username === "") {
                err++;
                if (lang == "EN") {
                    document.getElementById("usernameloginErr").innerHTML = "* Username missing";
                } else {
                    document.getElementById("usernameloginErr").innerHTML = "* Nome de usuário ausente";
                }

            }

            if (password === "") {
                err++;
                if (lang == "EN") {
                    document.getElementById("passwordloginErr").innerHTML = "* Password missing";
                } else {
                    document.getElementById("passwordloginErr").innerHTML = "* Palavra passe ausente";
                }
            }

            if (err == 0) { //only submit if I wrote something
                document.getElementById("formLogin").submit();
            }

        }

        //js validation for sign up
        function checkSignUp() {
            err2 = 0;
            firstname = document.getElementById("firstnamereg").value;
            lastname = document.getElementById("lastnamereg").value;
            username2 = document.getElementById("usernamereg").value;
            password2 = document.getElementById("passwordreg").value;

            if (firstname === "") {
                err2++;
                if (lang == "EN") {
                    document.getElementById("firstnameregErr").innerHTML = "* First name is missing";
                } else {
                    document.getElementById("firstnameregErr").innerHTML = "* Primeiro nome ausente";
                }
            }

            if (lastname === "") {
                err2++;
                if (lang == "EN") {
                    document.getElementById("lastnameregErr").innerHTML = "* Last name is missing";
                } else {
                    document.getElementById("lastnameregErr").innerHTML = "* Último nome ausente";
                }
            }

            if (username2 === "") {
                err2++;
                if (lang == "EN") {
                    document.getElementById("usernameregErr").innerHTML = "* Username is missing";
                } else {
                    document.getElementById("usernameregErr").innerHTML = "* Nome de usuário ausente";
                }
            }

            if (password2 === "") {
                err2++;
                if (lang == "EN") {
                    document.getElementById("passwordregErr").innerHTML = "* Password is missing";
                } else {
                    document.getElementById("passwordregErr").innerHTML = "* Palavra passe ausente";
                }
            }

            if (err2 == 0) { //only submit if I wrote something
                document.getElementById("formSignUp").submit();
            }

        }
    </script>
</head>

<body>

    <?php
    include_once("nav.php");
    navbar("user.php?lang=" . $otherlang, "logbutton", $toggle, $_GET["lang"]);
    ?>

    <section class="section1">


        <div class="BoxDiv">
            <form method="POST" id="formLogin">

                <h3><?php if ($_GET["lang"] == "EN") print "Sign In";
                    else print "Entrar" ?></h3>
                <div><?php if ($_GET["lang"] == "EN") print "Username";
                        else print "Nome do usuário" ?>:<input type="text" name="usernamelogin" id="usernamelogin"></div>
                <div id="usernameloginErr"></div>
                <br>
                <div><?php if ($_GET["lang"] == "EN") print "Password";
                        else print "Palavra de passe" ?>:<input type="password" name="passwordlogin" id="passwordlogin"></div>
                <div id="passwordloginErr"></div>


            </form>
            <br>
            <div><?php if ($wrongUser > 0) {
                        if ($_GET["lang"] == "EN") {
                            print "* Wrong User or Password";
                        } else {
                            print "* Usuário ou senha incorretos";
                        }
                    } ?></div>
            <br>
            <button onclick="checkLogin();"><?php if ($_GET["lang"] == "EN") print "Sign In";
                                            else print "Entrar" ?></button>
        </div>



        <br><br>

        <?php
        if (isset($_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $_POST["passwordreg"])) {

            $handle2 = @fopen("../database/users.txt", "r");
            if ($handle2) {
                while (!feof($handle2)) {
                    $buffer2 = fgets($handle2);
                    if (strpos($buffer2, $_POST["usernamereg"]) !== FALSE) {
                        //break;

                        $arraytest3 = explode(";", $buffer2);

                        if ($arraytest3[0] == $_POST["usernamereg"]) {
                            $UserFound = 1;;
                        }
                    }
                }
                fclose($handle2);
            }



            if ($UserFound == 0) {
                $fp = fopen('../database/users.txt', 'a+');

                $newUser =  $_POST["usernamereg"] . ";" . $_POST["passwordreg"] . ";" . $_POST["firstnamereg"] . ";" . $_POST["lastnamereg"] . ";" . "\n";
                if (fwrite($fp, $newUser)) {
                    $_SESSION["username"] = $_POST["usernamereg"];
                    $_SESSION["firstname"] = $_POST["firstnamereg"];
                    $_SESSION["lastname"] = $_POST["lastnamereg"];
                    echo '<script>window.location.href="Home' . $_GET["lang"] . '.php"</script>';
                } else {
                    die();
                }

                fclose($fp);
            }
        }

        ?>

        <div class="BoxDiv">
            <form method="POST" id="formSignUp">

                <h3><?php if ($_GET["lang"] == "EN") print "Sign Up";
                    else print "Inscrever-se" ?></h3>
                <div><?php if ($_GET["lang"] == "EN") print "First Name";
                        else print "Primeiro nome" ?>:<input type="text" name="firstnamereg" id="firstnamereg"></div>
                <div id="firstnameregErr"></div>
                <br>
                <div><?php if ($_GET["lang"] == "EN") print "Last Name";
                        else print "Último nome" ?>:<input type="text" name="lastnamereg" id="lastnamereg"></div>
                <div id="lastnameregErr"></div>
                <br>
                <div><?php if ($_GET["lang"] == "EN") print "Username";
                        else print "Nome do usuário" ?>:<input type="text" name="usernamereg" id="usernamereg"></div>
                <div id="usernameregErr"></div>
                <br>
                <div><?php if ($_GET["lang"] == "EN") print "Password";
                        else print "Palavra de passe" ?>:<input type="password" name="passwordreg" id="passwordreg"></div>
                <div id="passwordregErr"></div>


            </form>
            <br>
            <div><?php if ($UserFound > 0) {
                        if ($_GET["lang"] == "EN") {
                            print "* User already exist";
                        } else {
                            print "* O utilizador já existe";
                        }
                    } ?></div>
            <br>
            <button onclick="checkSignUp();"><?php if ($_GET["lang"] == "EN") print "Sign Up";
                                                else print "Inscrever-se" ?></button>
        </div>


    </section>

</body>

</html>