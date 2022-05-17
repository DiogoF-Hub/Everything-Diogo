<?php
include_once("start.php");


$wrongUser = 0;
$userexists = 0;

//regex
$regexUserName = "/[a-zA-Z0-9-_-]+/";
$regexFirstANDLastname = "/[\p{L}+u ]+/";
$regexEmail = "/[^@\s]+@[^@\s]/";



if (isset($_POST["usernamelogin"], $_POST["passwordlogin"])) {

    if (!preg_match($regexUserName, $_POST["usernamelogin"])) {
        die();
    }
    if (strlen($_POST["usernamelogin"]) < 1 || strlen($_POST["usernamelogin"]) > 50) {
        die();
    }


    if (strlen($_POST["passwordlogin"]) < 7 || strlen($_POST["passwordlogin"]) > 249) {
        die();
    }


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
            //$_SESSION["Chart"] = $row["Chart"];
            $_SESSION["Chart"] = [];
            $_SESSION["userloggedIn"] = true;
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
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../bootstrap/js/bootstrap.bundle.min.js'></script>
    <title>Acount page</title>
    <script>
        lang = "<?= $_SESSION["lang"] ?>";
        //js validation for login
        /*function checkLogin() {
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
                        document.getElementById("passwordregErrRepeat").innerHTML = "* As Palavra passes não correspondem";
                    }
                }
            }

            if (err2 == 0) { //only submit if no err
                document.getElementById("formSignUp").submit();
            }

        }*/

        function passwordCheck() {
            Password = document.getElementById("Password");
            PasswordRepeat = document.getElementById("PasswordRepeat");

            if (Password.value != PasswordRepeat.value) {
                PasswordRepeat.setCustomValidity("Both Passwords must match");
                PasswordRepeat.reportValidity();
            } else {
                PasswordRepeat.setCustomValidity("");
            }
        }

        /*function emailCheck() {
            Email = document.getElementById("email");

            Email.value.split("@");
        }*/

        function changeform(form) {
            if (form == "SignUp") {
                document.getElementById("SignIn").setAttribute("hidden", "hidden");
                document.getElementById("SignUp").removeAttribute("hidden");
            } else {
                document.getElementById("SignUp").setAttribute("hidden", "hidden");
                document.getElementById("SignIn").removeAttribute("hidden");
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

        <?php if ($_SESSION["userloggedIn"] == false) { ?>
            <form class="form-signin" method="POST" id="SignIn">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input name="usernamelogin" type="text" class="form-control" id="floatingInput" placeholder="User name" required pattern="[a-zA-Z0-9-_-]+" title="User Name must only contain 'A-Z', 'a-z', '0-9', '-', or '_'" oninput="reportValidity();" minlength="1" maxlength="25">
                    <label for="floatingInput">User name</label>
                </div>
                <div class="form-floating">
                    <input name="passwordlogin" type="password" class="form-control" id="floatingPassword" placeholder="Password" oninput="reportValidity();" required minlength="7">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

                <a id="createaccA" class="w-75 btn btn changeform" href='#' onclick="changeform('SignUp');">Create Account</a>

                <p class="mt-5 mb-3 text-muted">&copy; 2019–2022</p>
            </form>





            <form class="form-signup" method="POST" id="SignUp" hidden>
                <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

                <div class="form-floating">
                    <input name="firstnamereg" type="text" class="form-control" id="firstname" placeholder="First name" required pattern="[\p{L}\s]+" title="First name must contain only letters" oninput="reportValidity();" minlength="1" maxlength="50">
                    <label for="floatingInput">First name</label>
                </div>


                <div class="form-floating">
                    <input name="lastnamereg" type="text" class="form-control" id="lastname" placeholder="Last name" required pattern="[\p{L}\s]+" title="Last name must contain only letters" oninput="reportValidity()" minlength="1" maxlength="50">
                    <label for="floatingInput">Last name</label>
                </div>



                <div class="form-floating">
                    <input name="usernamereg" type="text" class="form-control" id="username" placeholder="User name" required pattern="[a-zA-Z0-9-_-]+" title="User Name must only contain 'A-Z', 'a-z', '0-9', '-', or '_'" oninput="reportValidity();" minlength="1" maxlength="25">
                    <label for="floatingInput">User name</label>
                </div>



                <div class="form-floating">
                    <input name="emailreg" type="email" class="form-control" id="email" placeholder="Email" required pattern="[^@\s]+@[^@\s]+" oninput="emailCheck();" minlength="1" maxlength="320">
                    <label for="floatingInput">Email</label>
                </div>



                <div class="form-floating">
                    <input name="passwordreg" type="password" class="form-control" id="Password" placeholder="Password" oninput="reportValidity();" required minlength="7" maxlength="249">
                    <label for="floatingInput">Password</label>
                </div>



                <div class="form-floating">
                    <input name="passwordregRepeat" type="password" class="form-control" id="PasswordRepeat" placeholder="Password Repeat" oninput="passwordCheck();" required minlength="7" maxlength="249">
                    <label for="floatingPassword">Password Repeat</label>
                </div>



                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

                <a id="LoginaccA" class="w-75 btn btn changeform" href='#' onclick="changeform('SignIn');">Login to existing Account</a>

                <p class="mt-5 mb-3 text-muted">&copy; 2019–2022</p>
            </form>

        <?php } ?>


        <?php
        if (isset($_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $_POST["emailreg"], $_POST["passwordreg"], $_POST["passwordregRepeat"])) {

            if (!preg_match($regexFirstANDLastname, $_POST["firstnamereg"])) {
                die();
            }
            if (strlen($_POST["firstnamereg"]) < 1 || strlen($_POST["firstnamereg"]) > 50) {
                die();
            }


            if (!preg_match($regexUserName, $_POST["usernamereg"])) {
                die();
            }
            if (strlen($_POST["usernamereg"]) < 1 || strlen($_POST["usernamereg"]) > 25) {
                die();
            }


            if (!preg_match($regexEmail, $_POST["emailreg"])) {
                die();
            }
            $emailExploded = explode("@", $_POST["emailreg"]);
            if (strlen($emailExploded[0]) > 64 || strlen($emailExploded[1]) > 255) {
                die();
            }


            if ($_POST["passwordreg"] !== $_POST["passwordregRepeat"]) {
                die();
            }
            if (strlen($_POST["passwordreg"]) < 7 || strlen($_POST["passwordreg"]) > 249) {
                die();
            }


            $sqlStatement = $connection->prepare("SELECT * from Users WHERE UserName=?");
            $sqlStatement->bind_param("s", $_POST["usernamereg"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $userexists = $result->num_rows;


            if ($userexists == 0) {
                $pswSignup = $_POST["passwordreg"];
                $hashPSW = password_hash($pswSignup, PASSWORD_DEFAULT);

                $sqlInsert = $connection->prepare("INSERT INTO Users (FirstName, LastName, UserName, Email, UserPassword) VALUES (?, ?, ?, ?, ?)");
                $sqlInsert->bind_param("sssss", $_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $_POST["emailreg"], $hashPSW);

                if ($sqlInsert->execute()) {
                    $_SESSION["username"] = $_POST["usernamereg"];
                    $_SESSION["firstname"] = $_POST["firstnamereg"];
                    $_SESSION["lastname"] = $_POST["lastnamereg"];
                    $_SESSION["Chart"] = [];
                    $_SESSION["userloggedIn"] = true;
                    echo '<script>window.location.href="Home.php"</script>';
                }
            }
        }

        ?>

    </section>

</body>

</html>