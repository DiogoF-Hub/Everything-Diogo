<?php
include_once("start.php");

$host = "localhost";
$user = "root";
$psw = "";
$database = "productsdatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);


$wrongUser = 0;
$userexists = 0;



if (isset($_POST["usernamelogin"], $_POST["passwordlogin"])) {

    $sqlStatement2 = $connection->prepare("SELECT * from Users WHERE UserName=?");
    $sqlStatement2->bind_param("s", $_POST["usernamelogin"]);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();
    $userexists2 = $result2->num_rows;

    if ($userexists2 == 1) {
        $row = $result2->fetch_assoc();
        if (password_verify($_POST["passwordlogin"], $row["UserPassword"])) {

            $_SESSION["username"] = $row["UserName"];
            $_SESSION["firstname"] = $row["FirstName"];
            $_SESSION["lastname"] = $row["LastName"];
            echo '<script>window.location.href="Home.php"</script>'; //This will redirect me to home to whatever language im in

        } else {
            $wrongUser = 1;
        }
    } else {
        $wrongUser = 1;
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <title>Acount page</title>
    <script>
        lang = "<?= $_SESSION["lang"] ?>";
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
            password2Repeat = document.getElementById("passwordregRepeat").value;

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

            if (password2 === "" || password2Repeat === "") {
                err2++;
                if (lang == "EN") {
                    document.getElementById("passwordregErr").innerHTML = "* Password is missing";
                    document.getElementById("passwordregErrRepeat").innerHTML = "* Password is missing";
                } else {
                    document.getElementById("passwordregErr").innerHTML = "* Palavra passe ausente";
                    document.getElementById("passwordregErrRepeat").innerHTML = "* Palavra passe ausente";
                }
            } else {
                if (password2 !== password2Repeat) {
                    err2++;
                    if (lang == "EN") {
                        document.getElementById("passwordregErrRepeat").innerHTML = "* Passwords dont match";
                    } else {
                        document.getElementById("passwordregErrRepeat").innerHTML = "* As Palavra passes não correspondem ";
                    }
                }
            }

            if (err2 == 0) { //only submit if no err
                document.getElementById("formSignUp").submit();
            }

        }
    </script>
</head>

<body>

    <?php
    include_once("nav.php");
    navbar("user.php?lang=" . $otherlang, "logbutton", $togle);
    ?>

    <section class="section1">


        <div class="BoxDiv">
            <form method="POST" id="formLogin">

                <h3><?php if ($_SESSION["lang"] == "EN") print "Sign In";
                    else print "Entrar" ?></h3>
                <div><?php if ($_SESSION["lang"] == "EN") print "Username";
                        else print "Nome do usuário" ?>:<input type="text" name="usernamelogin" id="usernamelogin"></div>
                <div id="usernameloginErr"></div>
                <br>
                <div><?php if ($_SESSION["lang"] == "EN") print "Password";
                        else print "Palavra de passe" ?>:<input type="password" name="passwordlogin" id="passwordlogin"></div>
                <div id="passwordloginErr"></div>


            </form>
            <br>
            <div><?php if ($wrongUser > 0) {
                        if ($_SESSION["lang"] == "EN") {
                            print "* Wrong User or Password";
                        } else {
                            print "* Usuário ou senha incorretos";
                        }
                    } ?></div>
            <br>
            <button onclick="checkLogin();"><?php if ($_SESSION["lang"] == "EN") print "Sign In";
                                            else print "Entrar" ?></button>
        </div>



        <br><br>

        <?php
        if (isset($_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $_POST["passwordreg"], $_POST["passwordregRepeat"])) {

            if ($_POST["passwordreg"] === $_POST["passwordregRepeat"]) {

                $sqlStatement = $connection->prepare("SELECT * from Users WHERE UserName=?");
                $sqlStatement->bind_param("s", $_POST["usernamereg"]);
                $sqlStatement->execute();
                $result = $sqlStatement->get_result();
                $userexists = $result->num_rows;


                if ($userexists == 0) {
                    $pswSignup = $_POST["passwordreg"];
                    $hashPSW = password_hash($pswSignup, PASSWORD_DEFAULT);

                    $sqlInsert = $connection->prepare("INSERT INTO Users (FirstName, LastName, UserName, UserPassword) VALUES (?, ?, ?, ?)");
                    $sqlInsert->bind_param("ssss", $_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $hashPSW);

                    if ($sqlInsert->execute()) {
                        $_SESSION["username"] = $_POST["usernamereg"];
                        $_SESSION["firstname"] = $_POST["firstnamereg"];
                        $_SESSION["lastname"] = $_POST["lastnamereg"];
                        echo '<script>window.location.href="Home.php"</script>';
                    }
                }
            } else {
                die();
            }
        }

        ?>

        <div class="BoxDiv">
            <form method="POST" id="formSignUp">

                <h3><?php if ($_SESSION["lang"] == "EN") print "Sign Up";
                    else print "Inscrever-se" ?></h3>
                <div><?php if ($_SESSION["lang"] == "EN") print "First Name";
                        else print "Primeiro nome" ?>:<input type="text" name="firstnamereg" id="firstnamereg"></div>
                <div id="firstnameregErr"></div>
                <br>
                <div><?php if ($_SESSION["lang"] == "EN") print "Last Name";
                        else print "Último nome" ?>:<input type="text" name="lastnamereg" id="lastnamereg"></div>
                <div id="lastnameregErr"></div>
                <br>
                <div><?php if ($_SESSION["lang"] == "EN") print "Username";
                        else print "Nome do usuário" ?>:<input type="text" name="usernamereg" id="usernamereg"></div>
                <div id="usernameregErr"></div>
                <br>
                <div><?php if ($_SESSION["lang"] == "EN") print "Password";
                        else print "Palavra de passe" ?>:<input type="password" name="passwordreg" id="passwordreg"></div>
                <div id="passwordregErr"></div>
                <br>
                <div><?php if ($_SESSION["lang"] == "EN") print "Repeat Password";
                        else print "Repita a Palavra de passe" ?>:<input type="password" name="passwordregRepeat" id="passwordregRepeat"></div>
                <div id="passwordregErrRepeat"></div>

            </form>

            <br>

            <div><?php if ($userexists > 0) {
                        if ($_SESSION["lang"] == "EN") {
                            print "* User already exist";
                        } else {
                            print "* O utilizador já existe";
                        }
                    } ?></div>
            <br>
            <button onclick="checkSignUp();"><?php if ($_SESSION["lang"] == "EN") print "Sign Up";
                                                else print "Inscrever-se" ?></button>
        </div>


    </section>

</body>

</html>