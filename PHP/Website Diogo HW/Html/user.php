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

            if (!empty($row["Chart"])) {
                $_SESSION["Chart"] = unserialize($row["Chart"]);
            } else {
                $_SESSION["Chart"] = [];
            }

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

            if (Password.value.length > 249) {
                Password.setCustomValidity("Passwords lenght must be less than 250 characters");
                Password.reportValidity();
            } else {
                Password.setCustomValidity("");
            }

            if (PasswordRepeat.value.length > 249) {
                PasswordRepeat.setCustomValidity("Passwords lenght must be less than 250 characters");
                PasswordRepeat.reportValidity();
            } else {
                PasswordRepeat.setCustomValidity("");
            }

            if (Password.value != PasswordRepeat.value) {
                PasswordRepeat.setCustomValidity("Both Passwords must match");
                PasswordRepeat.reportValidity();
            } else {
                PasswordRepeat.setCustomValidity("");
            }
        }

        function changeform(form) {
            if (form == "SignUp") {
                document.getElementById("SignIn").setAttribute("hidden", "hidden");
                document.getElementById("SignUp").removeAttribute("hidden");
            } else {
                document.getElementById("SignUp").setAttribute("hidden", "hidden");
                document.getElementById("SignIn").removeAttribute("hidden");
            }
        }

        function photoprofileEdit() {
            document.getElementById("photoprofileEdit").click();
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
                    <input name="emailreg" type="email" class="form-control" id="email" placeholder="Email" required pattern="[^@\s]+@[^@\s]+" title="Invalid email address" oninput="reportValidity();" minlength="1" maxlength="320">
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

        <?php } else {
        ?>
            <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
            <div class="container">
                <div class="row flex-lg-nowrap">
                    <div class="col-12 col-lg-auto mb-3" style="width: 200px;">
                        <div class="card p-3">
                            <div class="e-navlist e-navlist--active-bg">
                                <ul class="nav">
                                    <li class="nav-item"><a class="nav-link px-2 active" href="#"><i class="fa fa-fw fa-bar-chart mr-1"></i><span>Overview</span></a></li>
                                    <li class="nav-item"><a class="nav-link px-2" href="#" target="__blank"><i class="fa fa-fw fa-th mr-1"></i><span>CRUD</span></a></li>
                                    <li class="nav-item"><a class="nav-link px-2" href="#" target="__blank"><i class="fa fa-fw fa-cog mr-1"></i><span>Settings</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="row">
                            <div class="col mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="e-profile">
                                            <div class="row">
                                                <div class="col-12 col-sm-auto mb-3">
                                                    <div class="mx-auto" style="width: 140px;">
                                                        <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                            <!--<span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>-->
                                                            <img id="output" style="height: 140px; width: 140px;" src="" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">John Smith</h4>
                                                        <p class="mb-0">@johnny.s</p>
                                                        <div class="mt-2">
                                                            <form method="POST" id="photoprofileEditForm">
                                                                <input id="photoprofileEdit" name="photoprofileEdit" type="file" hidden accept="image/*" onchange="loadFile(event)">
                                                                <a href="javascript:{}" class="btn btn-primary" onclick="photoprofileEdit();">
                                                                    <i class="fa fa-fw fa-camera"></i>
                                                                    <span>Change Photo</span>
                                                                </a>
                                                                <script>
                                                                    var loadFile = function(event) {
                                                                        var output = document.getElementById('output');
                                                                        output.src = URL.createObjectURL(event.target.files[0]);
                                                                        output.onload = function() {
                                                                            URL.revokeObjectURL(output.src) // free memory
                                                                        }
                                                                    };
                                                                </script>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="text-center text-sm-right">
                                                        <span class="badge badge-secondary">administrator</span>
                                                        <div class="text-muted"><small>Joined 09 Dec 2017</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <div class="active nav-link">Settings</div>
                                                </li>
                                            </ul>
                                            <div class="tab-content pt-3">
                                                <div class="tab-pane active">
                                                    <div class="row">
                                                        <div class="col mb-3">

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>First Name</label>
                                                                        <input class="form-control" type="text" name="firstnameEdit" placeholder="John Smith" value="John Smith">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Last Name</label>
                                                                        <input class="form-control" type="text" name="lastnameEdit" placeholder="johnny.s" value="johnny.s">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Username</label>
                                                                        <input class="form-control" type="text" name="usernameEdit" placeholder="DFER7" value="DFER7">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control" type="text" placeholder="user@example.com">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <script>
                                                                            function changeDateFocus() {
                                                                                DateOfBirth = document.getElementById("DateOfBirth");
                                                                                DateOfBirth.type = 'date';
                                                                                DateOfBirth.placeholder = " ";
                                                                                DateOfBirth.value = '2022-05-12'; //print date from database
                                                                            }

                                                                            function changeDateBlur() {
                                                                                DateOfBirth1 = document.getElementById("DateOfBirth");
                                                                                if (!DateOfBirth1.value) {
                                                                                    DateOfBirth1.type = 'text'
                                                                                }
                                                                            }
                                                                        </script>
                                                                        <label>Date of Birth</label>
                                                                        <input id="DateOfBirth" class="form-control" type="text" placeholder="12-May-2022" onfocus="changeDateFocus();" onblur="changeDateBlur();">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2"><b>Address</b></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Address line 1</label>
                                                                        <input class="form-control" type="text" name="Addressline1" placeholder="Address line 1" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group w-50">
                                                                        <label>Street Number</label>
                                                                        <input class="form-control" type="number" name="streetNumber" placeholder="Street Number" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group" style="width: 48.467%;">
                                                                        <label>Address line 2</label>
                                                                        <input class="form-control" type="text" name="Addressline2" placeholder="Address line 2" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>City</label>
                                                                        <input class="form-control" type="text" name="City" placeholder="City" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group w-50">
                                                                        <label>Postal Code</label>
                                                                        <input class="form-control" type="text" name="PostalCode" placeholder="Postal Code" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6 mb-3">
                                                            <div class="mb-2"><b>Change Password</b></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Current Password</label>
                                                                        <input class="form-control" type="password" placeholder="••••••" name="CurrentPassword">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>New Password</label>
                                                                        <input class="form-control" type="password" placeholder="••••••" name="PasswordEdit" id="Password" oninput="reportValidity();" required minlength="7" maxlength="249">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                                                                        <input class="form-control" type="password" placeholder="••••••" name="PasswordRepeatEdit" id="PasswordRepeat" oninput="passwordCheck();" required minlength="7" maxlength="249">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                                                            <div class="mb-2"><b>Keeping in Touch</b></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label>Email Notifications</label>
                                                                    <div class="custom-controls-stacked px-2">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="notifications-blog" checked="">
                                                                            <label class="custom-control-label" for="notifications-blog">Blog posts</label>
                                                                        </div>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="notifications-news" checked="">
                                                                            <label class="custom-control-label" for="notifications-news">Newsletter</label>
                                                                        </div>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="notifications-offers" checked="">
                                                                            <label class="custom-control-label" for="notifications-offers">Personal Offers</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <button class="btn btn-primary" type="submit">Save Changes</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="px-xl-3">
                                            <button class="btn btn-block btn-secondary">
                                                <i class="fa fa-sign-out"></i>
                                                <span>Logout</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold">Support</h6>
                                        <p class="card-text">Get fast, free help from our friendly assistants.</p>
                                        <button type="button" class="btn btn-primary">Contact Us</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </form>
        <?php
        } ?>


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

                $todayDate = date("d-m-Y");

                echo "<script>alert('" . $todayDate . "');</script>";

                $sqlInsert = $connection->prepare("INSERT INTO Users (FirstName, LastName, UserName, Email, UserPassword, Chart, UserType, JoinDate, DateOfBirth) VALUES (?, ?, ?, ?, ?, '','Normal', '" . $todayDate . "', '')");
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