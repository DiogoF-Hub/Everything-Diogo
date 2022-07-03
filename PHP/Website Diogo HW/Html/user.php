<?php
include_once("start.php");

//regex
$regexUserName = "/[a-zA-Z0-9-_-]+/";
$regexFirstANDLastname = "/[\p{L}+u ]+/";
$regexEmail = "/[^@\s]+@[^@\s]/";


if (isset($_POST["usernamelogin"], $_POST["passwordlogin"])) {

    if (!preg_match($regexUserName, $_POST["usernamelogin"])) {
        header("Refresh:0");
        die();
    }
    if (strlen($_POST["usernamelogin"]) < 1 || strlen($_POST["usernamelogin"]) > 50) {
        header("Refresh:0");
        die();
    }


    if (strlen($_POST["passwordlogin"]) < 7 || strlen($_POST["passwordlogin"]) > 249) {
        header("Refresh:0");
        die();
    }

    $usernametrimmed = trim($_POST["usernamelogin"]);
    $sqlStatement2 = $connection->prepare("SELECT * from Users WHERE UserName=?");
    $sqlStatement2->bind_param("s", $usernametrimmed);
    $sqlStatement2->execute();
    $result2 = $sqlStatement2->get_result();
    $userexists2 = $result2->num_rows;

    if ($userexists2 == 1) {
        $row = $result2->fetch_assoc();
        if (password_verify($_POST["passwordlogin"], $row["UserPassword"])) {

            $_SESSION["UserID"] = $row["UserID"];
            $_SESSION["username"] = $row["UserName"];
            $_SESSION["firstname"] = $row["FirstName"];
            $_SESSION["lastname"] = $row["LastName"];
            $_SESSION["UserType"] = $row["UserType"];

            if (!empty($row["Chart"])) {
                $_SESSION["Chart"] = unserialize($row["Chart"]);
            } else {
                $_SESSION["Chart"] = [];
            }

            $_SESSION["userloggedIn"] = true;
            header("Location: Home.php");
            die();
        } else {
            if ($_SESSION["lang"] == "EN") {
                print "<script>alert('Password does not match');</script>";
            } else {
                print "<script>alert('Senha não corresponde');</script>";
            }

            header("Refresh:0");
            die();
        }
    } else {
        if ($_SESSION["lang"] == "EN") {
            print "<script>alert('User does not exist');</script>";
        } else {
            print "<script>alert('Usuário não existe');</script>";
        }
        header("Refresh:0");
        die();
    }
}



if (isset($_POST["firstnamereg"], $_POST["lastnamereg"], $_POST["usernamereg"], $_POST["emailreg"], $_POST["passwordreg"], $_POST["passwordregRepeat"])) {

    $firstnamereg = trim($_POST["firstnamereg"]);
    $lastnamereg = trim($_POST["lastnamereg"]);
    $usernamereg = trim($_POST["usernamereg"]);
    $emailreg = trim($_POST["emailreg"]);


    if (!preg_match($regexFirstANDLastname, $firstnamereg)) {
        header("Refresh:0");
        die();
    }
    if (strlen($firstnamereg) < 1 || strlen($firstnamereg) > 100) {
        header("Refresh:0");
        die();
    }


    if (!preg_match($regexFirstANDLastname, $lastnamereg)) {
        header("Refresh:0");
        die();
    }
    if (strlen($lastnamereg) < 1 || strlen($lastnamereg) > 100) {
        header("Refresh:0");
        die();
    }


    if (!preg_match($regexUserName, $usernamereg)) {
        header("Refresh:0");
        die();
    }
    if (strlen($usernamereg) < 1 || strlen($usernamereg) > 25) {
        header("Refresh:0");
        die();
    }


    if (!preg_match($regexEmail, $emailreg)) {
        header("Refresh:0");
        die();
    }
    $emailExploded = explode("@", $emailreg);
    if (strlen($emailExploded[0]) > 64 || strlen($emailExploded[1]) > 255) {
        header("Refresh:0");
        die();
    }


    if ($_POST["passwordreg"] !== $_POST["passwordregRepeat"]) {
        header("Refresh:0");
        die();
    }
    if (strlen($_POST["passwordreg"]) < 7 || strlen($_POST["passwordreg"]) > 249) {
        header("Refresh:0");
        die();
    }


    $sqlStatement = $connection->prepare("SELECT * from Users WHERE UserName=?");
    $sqlStatement->bind_param("s", $usernamereg);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $userexists = $result->num_rows;


    if ($userexists == 0) {
        $pswSignup = $_POST["passwordreg"];
        $hashPSW = password_hash($pswSignup, PASSWORD_DEFAULT);

        $sqlInsert = $connection->prepare("INSERT INTO Users (FirstName, LastName, UserName, Email, UserPassword, Chart, UserType, JoinDate, DateOfBirth, ProfilePic, Civility, FirstLineAddress, HouseNumber, SecondLineAddress, PostalCode, City, countryId) VALUES (?, ?, ?, ?, ?, '','Normal', current_date(), '', '', '', '', '', '', '', '', 1)");
        $sqlInsert->bind_param("sssss", $firstnamereg, $lastnamereg, $usernamereg, $emailreg, $hashPSW);

        if ($sqlInsert->execute()) {
            $sqlID = $connection->prepare("SELECT UserID from Users ORDER BY UserID DESC LIMIT 1");
            $sqlID->execute();
            $result = $sqlID->get_result();
            $row = $result->fetch_assoc();

            $_SESSION["UserID"] = $row["UserID"];
            $_SESSION["username"] = $usernamereg;
            $_SESSION["firstname"] = $firstnamereg;
            $_SESSION["lastname"] = $lastnamereg;
            $_SESSION["Chart"] = [];
            $_SESSION["UserType"] = "Normal";
            $_SESSION["userloggedIn"] = true;

            header("Location: Home.php");
            die();
        }
    } else {
        if ($_SESSION["lang"] == "EN") {
            print "<script>alert('User already exists');</script>";
        } else {
            print "<script>alert('Usuário já existe');</script>";
        }
        header("Refresh:0");
        die();
    }
}




if (isset($_FILES['photoprofileEditIMG']) && $_SESSION["userloggedIn"] == true) {
    $file_name = $_SESSION["username"];
    $file_size = $_FILES['photoprofileEditIMG']['size'];
    $file_tmp = $_FILES['photoprofileEditIMG']['tmp_name'];
    $file_type = $_FILES['photoprofileEditIMG']['type'];
    $arrEXT = explode('.', $_FILES['photoprofileEditIMG']['name']);

    $FiveDigitRandomNumber = rand(10000, 99999);

    $file_ext = strtolower($arrEXT[count($arrEXT) - 1]);

    $sqlStatement5 = $connection->prepare("SELECT * from Users WHERE UserName=?");
    $sqlStatement5->bind_param("s", $_SESSION["username"]);
    $sqlStatement5->execute();
    $result = $sqlStatement5->get_result();
    $row = $result->fetch_assoc();

    if (!empty($row["ProfilePic"])) {
        unlink("../database/ProfilePics/" . $row["ProfilePic"]);
    }

    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        if ($_SESSION["lang"] == "EN") {
            print "<script>alert('Extension not allowed, please choose a JPEG, PNG or JPG file.');</script>";
        } else {
            print "<script>alert('Extensão não permitida, escolha um arquivo JPEG, PNG ou JPG.');</script>";
        }
        header("Refresh:0");
        die();
    }

    if ($file_size > 26214400) {
        if ($_SESSION["lang"] == "EN") {
            print "<script>alert('File size must be less than or 25 MB.');</script>";
        } else {
            print "<script>alert('O tamanho do arquivo deve ser menor ou 25 MB.');</script>";
        }
        header("Refresh:0");
        die();
    }

    $fullFileName = $file_name . "-" . $FiveDigitRandomNumber .  "." . $file_ext;

    if (move_uploaded_file($file_tmp, "../database/ProfilePics/" . $fullFileName)) {

        $sqlStatement5 = $connection->prepare("UPDATE Users SET ProfilePic=? WHERE UserName=?");
        $sqlStatement5->bind_param("ss", $fullFileName, $_SESSION["username"]);
        $sqlStatement5->execute();
    }
}


if (isset($_POST["firstnameEdit"]) && $_SESSION["userloggedIn"] == true) {
    $sqlStatement4 = $connection->prepare("SELECT FirstName, LastName, Email, UserType, ProfilePic, DATE_FORMAT(JoinDate, '%e %b %Y') AS DateJoin, DATE_FORMAT(DateOfBirth, '%e') AS DayBirth, DATE_FORMAT(DateOfBirth, '%c') AS MonthBirth, DATE_FORMAT(DateOfBirth, '%Y') AS YearBirth, Civility, FirstLineAddress, HouseNumber, SecondLineAddress, PostalCode, City, countryId from Users WHERE UserName=?");
    $sqlStatement4->bind_param("s", $_SESSION["username"]);
    $sqlStatement4->execute();
    $result4 = $sqlStatement4->get_result();
    $row3 = $result4->fetch_assoc();

    $firstnameEdit = trim($_POST["firstnameEdit"]);
    if ($firstnameEdit != $row3["FirstName"]) {
        if (!preg_match($regexFirstANDLastname, $firstnameEdit)) {
            header("Refresh:0");
            die();
        }
        $sqlUpdate = $connection->prepare("UPDATE Users SET FirstName=? WHERE UserName=?");
        $sqlUpdate->bind_param("ss", $firstnameEdit, $_SESSION["username"]);
        $sqlUpdate->execute();
        $_SESSION["firstname"] = $firstnameEdit;
    }


    $lastnameEdit = trim($_POST["lastnameEdit"]);
    if ($lastnameEdit != $row3["LastName"]) {
        if (!preg_match($regexFirstANDLastname, $lastnameEdit)) {
            header("Refresh:0");
            die();
        }
        $sqlUpdate1 = $connection->prepare("UPDATE Users SET LastName=? WHERE UserName=?");
        $sqlUpdate1->bind_param("ss", $lastnameEdit, $_SESSION["username"]);
        $sqlUpdate1->execute();
        $_SESSION["lastname"] = $lastnameEdit;
    }


    $emailEdit = trim($_POST["emailEdit"]);
    if ($emailEdit != $row3["Email"]) {
        if (!preg_match($regexEmail, $emailEdit)) {
            header("Refresh:0");
            die();
        }
        $sqlUpdate2 = $connection->prepare("UPDATE Users SET Email=? WHERE UserName=?");
        $sqlUpdate2->bind_param("ss", $emailEdit, $_SESSION["username"]);
        $sqlUpdate2->execute();
    }

    if ($_SESSION["lang"] == "EN") {
        $monthsArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    } else {
        $monthsArr = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    }

    $DaysN = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    (int)$ThisYear = date("Y");

    if (isset($_POST["monthSelect"], $_POST["daySelect"], $_POST["yearSelect"])) {
        if (is_numeric($_POST["monthSelect"]) && is_numeric($_POST["yearSelect"]) && is_numeric($_POST["daySelect"])) {
            if ($_POST["monthSelect"] > 0 && $_POST["monthSelect"] < 13 && $_POST["yearSelect"] > 1909 && $_POST["yearSelect"] < $ThisYear + 1) {
                if ($_POST["daySelect"] <= $DaysN[$_POST["monthSelect"] - 1]) {
                    //$daySTR = $_POST["daySelect"] . ", " . $_POST["monthSelect"] . ", " . $_POST["yearSelect"];

                    $date = new DateTime();
                    $date->setDate($_POST["yearSelect"], $_POST["monthSelect"], $_POST["daySelect"]);
                    $daySTR = $date->format('Y-m-d');
                    $sqlUpdate3 = $connection->prepare("UPDATE Users SET DateOfBirth =? WHERE UserName=?");
                    $sqlUpdate3->bind_param("ss", $daySTR, $_SESSION["username"]);
                    $sqlUpdate3->execute();
                } else {
                    header("Refresh:0");
                    die();
                }
            } else {
                header("Refresh:0");
                die();
            }
        } else {
            header("Refresh:0");
            die();
        }
    }



    if (!empty($_POST["Addressline1"])) {
        $Addressline1 = trim($_POST["Addressline1"]);
        if ($Addressline1 != $row3["FirstLineAddress"]) {
            $sqlUpdate4 = $connection->prepare("UPDATE Users SET FirstLineAddress=? WHERE UserName=?");
            $sqlUpdate4->bind_param("ss", $Addressline1, $_SESSION["username"]);
            $sqlUpdate4->execute();
        }
    }


    if (!empty($_POST["StreetNumber"])) {
        $StreetNumber = trim($_POST["StreetNumber"]);
        if ($StreetNumber != $row3["HouseNumber"]) {
            $sqlUpdate5 = $connection->prepare("UPDATE Users SET HouseNumber=? WHERE UserName=?");
            $sqlUpdate5->bind_param("ss", $StreetNumber, $_SESSION["username"]);
            $sqlUpdate5->execute();
        }
    }


    if (!empty($_POST["Addressline2"])) {
        $Addressline2 = trim($_POST["Addressline2"]);
        if ($Addressline2 != $row3["SecondLineAddress"]) {
            $sqlUpdate6 = $connection->prepare("UPDATE Users SET SecondLineAddress=? WHERE UserName=?");
            $sqlUpdate6->bind_param("ss", $Addressline2, $_SESSION["username"]);
            $sqlUpdate6->execute();
        }
    }


    if (!empty($_POST["City"])) {
        $City = trim($_POST["City"]);
        if ($City != $row3["City"]) {
            $sqlUpdate7 = $connection->prepare("UPDATE Users SET City=? WHERE UserName=?");
            $sqlUpdate7->bind_param("ss", $City, $_SESSION["username"]);
            $sqlUpdate7->execute();
        }
    }


    if (!empty($_POST["PostalCode"])) {
        $PostalCode = trim($_POST["PostalCode"]);
        if ($PostalCode != $row3["PostalCode"]) {
            $sqlUpdate8 = $connection->prepare("UPDATE Users SET PostalCode=? WHERE UserName=?");
            $sqlUpdate8->bind_param("ss", $PostalCode, $_SESSION["username"]);
            $sqlUpdate8->execute();
        }
    }


    if (!empty($_POST["Civility"])) {
        $Civility = trim($_POST["Civility"]);
        $CivilityArr = ["mr", "ms"];
        if (in_array($Civility, $CivilityArr)) {
            if ($Civility  != $row3["Civility"]) {
                $sqlUpdate9 = $connection->prepare("UPDATE Users SET Civility=? WHERE UserName=?");
                $sqlUpdate9->bind_param("ss", $Civility, $_SESSION["username"]);
                $sqlUpdate9->execute();
            }
        } else {
            header("Refresh:0");
            die();
        }
    }


    if (!empty($_POST["Country"])) {
        if ($_POST["Country"] != 1) {
            $sql = $connection->prepare("SELECT countryId From AvailableCountries WHERE countryId=?");
            $sql->bind_param("i", $_POST["Country"]);
            $sql->execute();
            $result = $sql->get_result();
            $numRows = $result->num_rows;
            $row = $result->fetch_assoc();
            if ($numRows == 1) {
                if ($row3["countryId"] != $_POST["Country"]) {
                    $sqlUpdate10 = $connection->prepare("UPDATE Users SET countryId=? WHERE UserName=?");
                    $sqlUpdate10->bind_param("ss", $row["countryId"], $_SESSION["username"]);
                    $sqlUpdate10->execute();
                }
            } else {
                header("Refresh:0");
                die();
            }
        }
    }
}


if (isset($_POST["CurrentPassword"], $_POST["PasswordEdit"], $_POST["PasswordRepeatEdit"]) && $_SESSION["userloggedIn"] == true) {
    $CurrentPassword = trim($_POST["CurrentPassword"]);
    $PasswordEdit = trim($_POST["PasswordEdit"]);
    $PasswordRepeatEdit = trim($_POST["PasswordRepeatEdit"]);

    if (strlen($CurrentPassword) < 7 || strlen($PasswordEdit) < 7 || strlen($PasswordRepeatEdit) < 7) {
        header("Refresh:0");
        die();
    } else {
        $sqlStatement11 = $connection->prepare("SELECT UserPassword from Users WHERE UserName=?");
        $sqlStatement11->bind_param("s", $_SESSION["username"]);
        $sqlStatement11->execute();
        $result11 = $sqlStatement11->get_result();
        $row11 = $result11->fetch_assoc();
        if (password_verify($CurrentPassword, $row11["UserPassword"])) {
            $hashPSWEdit = password_hash($PasswordEdit, PASSWORD_DEFAULT);

            $sqlUpdate12 = $connection->prepare("UPDATE Users SET UserPassword=? WHERE UserName=?");
            $sqlUpdate12->bind_param("ss", $hashPSWEdit, $_SESSION["username"]);
            $sqlUpdate12->execute();

            if ($_SESSION["lang"] == "EN") {
                print "<script>alert('Your Current Password has been changed');</script>";
            } else {
                print "<script>alert('Sua senha atual foi alterada');</script>";
            }
            header("Refresh:0");
            die();
        } else {
            if ($_SESSION["lang"] == "EN") {
                print "<script>alert('Your Current Password does not match');</script>";
            } else {
                print "<script>alert('Sua senha atual não corresponde');</script>";
            }
            header("Refresh:0");
            die();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="../jquery/dateSelect.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Acount page</title>
    <script>
        lang = "<?= $_SESSION["lang"] ?>";

        function passwordCheck() {
            Password = document.getElementById("Password");
            PasswordRepeat = document.getElementById("PasswordRepeat");

            if (Password.value != PasswordRepeat.value) {
                if (lang == "EN") {
                    PasswordRepeat.setCustomValidity("Both Passwords must match");
                } else {
                    PasswordRepeat.setCustomValidity("Ambas as senhas devem corresponder");
                }
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

        function submitSettings() {
            photoprofileEdit = document.getElementById("photoprofileEdit");
            if (photoprofileEdit.files.length == 0) {
                photoprofileEdit.remove();
            }
            document.getElementById("infoForm").submit();
        }

        function passwordCheckEdit() {
            Password = document.getElementById("PasswordEdit");
            PasswordRepeat = document.getElementById("PasswordRepeatEdit");

            if (Password.value != PasswordRepeat.value) {
                if (lang == "EN") {
                    PasswordRepeat.setCustomValidity("Both Passwords must match");
                } else {
                    PasswordRepeat.setCustomValidity("Ambas as senhas devem corresponder");
                }
                PasswordRepeat.reportValidity();
            } else {
                PasswordRepeat.setCustomValidity("");
            }

        }


        function checklogin() {
            UserSignIn = document.getElementById("UserSignIn");
            pswSignIn = document.getElementById("pswSignIn");

            if (UserSignIn.value.trim().length != 0 && pswSignIn.value.trim().length != 0) {
                SignIn = document.getElementById("SignIn").submit();
            } else {
                if (lang == "EN") {
                    UserSignIn.setCustomValidity("User Name must only contain 'A-Z', 'a-z', '0-9', '-', or '_'");
                } else {
                    UserSignIn.setCustomValidity("O nome de usuário deve conter apenas 'A-Z', 'a-z', '0-9', '-' ou '_'");
                }
                UserSignIn.reportValidity();
                pswSignIn.reportValidity
            }
        }


        var loadFile = function(event) {
            var spanIMG = document.getElementById("spanIMG");
            var output = document.getElementById('output');

            if (spanIMG.hasAttribute("hidden") == false) {
                spanIMG.setAttribute("hidden", "hidden");
            }

            if (output.hasAttribute("hidden")) {
                output.removeAttribute("hidden");
            }

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };


        function changeNavItem(tab) {
            if (tab == "settings") {
                document.getElementById("securityTab").setAttribute("hidden", "hidden");
                document.getElementById("ordersTab").setAttribute("hidden", "hidden");
                document.getElementById("settingsTab").removeAttribute("hidden", "hidden");

                document.getElementById("security-link").classList.remove('active');
                document.getElementById("orders-link").classList.remove('active');
                document.getElementById("settings-link").classList.add('active');
            }

            if (tab == "security") {
                document.getElementById("settingsTab").setAttribute("hidden", "hidden");
                document.getElementById("ordersTab").setAttribute("hidden", "hidden");
                document.getElementById("securityTab").removeAttribute("hidden", "hidden");

                document.getElementById("settings-link").classList.remove('active');
                document.getElementById("orders-link").classList.remove('active');
                document.getElementById("security-link").classList.add('active');
            }

            if (tab == "orders") {
                document.getElementById("settingsTab").setAttribute("hidden", "hidden");
                document.getElementById("securityTab").setAttribute("hidden", "hidden");
                document.getElementById("ordersTab").removeAttribute("hidden", "hidden");

                document.getElementById("settings-link").classList.remove('active');
                document.getElementById("security-link").classList.remove('active');
                document.getElementById("orders-link").classList.add('active');
            }

        }


        function changePSW() {
            CurrentPassword = document.getElementById("CurrentPassword").value;
            PasswordEdit = document.getElementById("PasswordEdit").value;
            PasswordRepeatEdit = document.getElementById("PasswordRepeatEdit").value;
            if (CurrentPassword.length == 0 || PasswordEdit.length == 0 || PasswordRepeatEdit.length == 0) {
                if (lang = "EN") {
                    alert("All the fields must be fulfilled to change the Password");
                } else {
                    alert("Todos os campos devem ser preenchidos para alterar a Senha");
                }

            } else {
                document.getElementById("changePSWFform").submit();
            }
        }
    </script>
</head>

<body>

    <?php
    include_once("nav.php");
    navbar("user.php?lang=" . $otherlang, "user", $sqlLang);
    ?>

    <section class="section1">

        <?php if ($_SESSION["userloggedIn"] == false) { ?>
            <form class="form-signin" method="POST" id="SignIn">
                <h1 class="h3 mb-3 fw-normal"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "Please sign in";
                                                } else {
                                                    print "Por favor, entre";
                                                } ?></h1>

                <div class="form-floating">
                    <input name="usernamelogin" type="text" class="form-control" id="UserSignIn" placeholder="User name" required pattern="[a-zA-Z0-9-_-]+" oninput="reportValidity();" minlength="1" maxlength="25">
                    <label for="floatingInput"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "User name";
                                                } else {
                                                    print "Nome de usuário";
                                                } ?></label>
                </div>
                <div class="form-floating">
                    <input name="passwordlogin" type="password" class="form-control" id="pswSignIn" placeholder="Password" oninput="reportValidity();" required minlength="7">
                    <label for="floatingPassword"><?php if ($_SESSION["lang"] == "EN") {
                                                        print "Password";
                                                    } else {
                                                        print "Senha";
                                                    } ?></label>
                </div>

                <a class="w-100 btn btn-lg btn-primary" href="javascript:{}" onclick="checklogin();"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                            print "Sign in";
                                                                                                        } else {
                                                                                                            print "Entrar";
                                                                                                        } ?></a>
                <a id="createaccA" class="w-75 btn btn changeform" href="javascript:{}" onclick="changeform('SignUp');"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                            print "Create Account";
                                                                                                                        } else {
                                                                                                                            print "Criar uma conta";
                                                                                                                        } ?></a>
                <p class="mt-5 mb-3 text-muted">&copy; 2019–2022</p>
            </form>



            <form class="form-signup" method="POST" id="SignUp" hidden>
                <h1 class="h3 mb-3 fw-normal"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "Please sign up";
                                                } else {
                                                    print "Por favor, inscreva-se";
                                                } ?></h1>

                <div class="form-floating">
                    <input name="firstnamereg" type="text" class="form-control" id="firstname" placeholder="First name" required pattern="[\p{L}\s]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                    print "First name must contain only letters";
                                                                                                                                                                } else {
                                                                                                                                                                    print "O nome deve conter apenas letras";
                                                                                                                                                                } ?>" oninput="reportValidity();" minlength="1" maxlength="100">
                    <label for="floatingInput"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "First name";
                                                } else {
                                                    print "Primeiro nome";
                                                } ?></label>
                </div>

                <div class="form-floating">
                    <input name="lastnamereg" type="text" class="form-control" id="lastname" placeholder="Last name" required pattern="[\p{L}\s]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                print "Last name must contain only letters";
                                                                                                                                                            } else {
                                                                                                                                                                print "O sobrenome deve conter apenas letras";
                                                                                                                                                            } ?>" oninput="reportValidity()" minlength="1" maxlength="100">
                    <label for="floatingInput"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "Last name";
                                                } else {
                                                    print "Sobrenome";
                                                } ?></label>
                </div>

                <div class="form-floating">
                    <input name="usernamereg" type="text" class="form-control" id="username" placeholder="User name" required pattern="[a-zA-Z0-9-_-]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                    print "User Name must only contain 'A-Z', 'a-z', '0-9', '-', or '_'";
                                                                                                                                                                } else {
                                                                                                                                                                    print "O nome de usuário deve conter apenas 'A-Z', 'a-z', '0-9', '-' ou '_'";
                                                                                                                                                                } ?>" oninput="reportValidity();" minlength="1" maxlength="25">
                    <label for="floatingInput"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "User name";
                                                } else {
                                                    print "Nome de usuário";
                                                } ?></label>
                </div>

                <div class="form-floating">
                    <input name="emailreg" type="email" class="form-control" id="email" placeholder="Email" required pattern="[^@\s]+@[^@\s]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                            print "Invalid email address";
                                                                                                                                                        } else {
                                                                                                                                                            print "Endereço de email invalido";
                                                                                                                                                        } ?>" oninput="reportValidity();" minlength="1" maxlength="320">
                    <label for="floatingInput">Email</label>
                </div>

                <div class="form-floating">
                    <input name="passwordreg" type="password" class="form-control" id="Password" placeholder="Password" oninput="reportValidity();" required minlength="7" maxlength="249">
                    <label for="floatingInput"><?php if ($_SESSION["lang"] == "EN") {
                                                    print "Password";
                                                } else {
                                                    print "Senha";
                                                } ?></label>
                </div>

                <div class="form-floating">
                    <input name="passwordregRepeat" type="password" class="form-control" id="PasswordRepeat" placeholder="Password Repeat" oninput="passwordCheck();" required minlength="7" maxlength="249">
                    <label for="floatingPassword"><?php if ($_SESSION["lang"] == "EN") {
                                                        print "Password Repeat";
                                                    } else {
                                                        print "Repetição da senha";
                                                    } ?></label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit"><?php if ($_SESSION["lang"] == "EN") {
                                                                                print "Sign in";
                                                                            } else {
                                                                                print "Entrar";
                                                                            } ?></button>
                <a id="LoginaccA" class="w-75 btn btn changeform" href='#' onclick="changeform('SignIn');"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                print "Login to existing Account";
                                                                                                            } else {
                                                                                                                print "Faça login na conta existente";
                                                                                                            } ?></a>
                <p class="mt-5 mb-3 text-muted">&copy; 2019–2022</p>
            </form>

        <?php } else {
            $sqlStatement2 = $connection->prepare("SELECT * FROM UserLoggedIn WHERE UserName=?");
            $sqlStatement2->bind_param("s", $_SESSION["username"]);
            $sqlStatement2->execute();
            $result2 = $sqlStatement2->get_result();
            $row = $result2->fetch_assoc();

        ?>

            <div class="container">
                <div class="row flex-lg-nowrap">

                    <!-- php hide if not admin -->
                    <?php
                    if ($row["UserType"] == "Admin") {
                    ?>
                        <div class="col-12 col-lg-auto mb-3" style="width: 200px;">
                            <div class="card p-3">
                                <div class="e-navlist e-navlist--active-bg">
                                    <ul class="nav">
                                        <li class="nav-item"><a class="nav-link px-2" href="createProduct.php"><i class="fa fa-plus-square mr-1"></i><span> Create Product</span></a></li>
                                        <li class="nav-item"><a class="nav-link px-2" href="orders.php"><i class="fa fa-fw fa-th mr-1"></i><span>Orders</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                    <div class="col">
                        <div class="row">
                            <div class="col mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="e-profile">
                                            <div class="row">
                                                <div class="col-12 col-sm-auto mb-3">
                                                    <div class="mx-auto" style="width: 140px;">
                                                        <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239); border: 1px solid black;">
                                                            <span id="spanIMG" <?php if (!empty($row["ProfilePic"])) print "hidden"; ?> style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                                                            <img id="output" style="height: 140px; width: 140px;" <?php if (!empty($row["ProfilePic"])) {
                                                                                                                        print "src='../database/ProfilePics/" . $row["ProfilePic"] . "'";
                                                                                                                    } else {
                                                                                                                        print "hidden";
                                                                                                                    } ?> alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?= $row["FirstName"] . " " . $row["LastName"] ?></h4>
                                                        <p class="mb-0">@<?= $row["UserName"] ?></p>
                                                        <div class="mt-2">

                                                            <form method="POST" id="infoForm" enctype="multipart/form-data">
                                                                <input hidden id="photoprofileEdit" name="photoprofileEditIMG" type="file" accept=".png, .jpg, .jpeg" onchange="loadFile(event)">
                                                                <a href="javascript:{}" class="btn btn-primary" onclick="photoprofileEdit();">
                                                                    <i class="fa fa-fw fa-camera"></i>
                                                                    <span><?php if ($_SESSION["lang"] == "EN") {
                                                                                print "Change Photo";
                                                                            } else {
                                                                                print "Mudar foto";
                                                                            } ?></span>
                                                                </a>
                                                        </div>
                                                    </div>
                                                    <div class="text-center text-sm-right">
                                                        <div class="text-muted"><small><?php if ($_SESSION["lang"] == "EN") {
                                                                                            print "Joined";
                                                                                        } else {
                                                                                            print "Ingressou";
                                                                                        } ?> <?= $row["DateJoin"] ?></small></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"><a id="settings-link" href="javascript:{}" class="active nav-link" onclick="changeNavItem('settings');"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                    print "Settings";
                                                                                                                                                                                } else {
                                                                                                                                                                                    print "Definições";
                                                                                                                                                                                } ?></a></li>
                                                <li class="nav-item"><a id="security-link" href="javascript:{}" class="nav-link" onclick="changeNavItem('security');"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                            print "Security";
                                                                                                                                                                        } else {
                                                                                                                                                                            print "Segurança";
                                                                                                                                                                        } ?></a></li>
                                                <li class="nav-item"><a id="orders-link" href="javascript:{}" class="nav-link" onclick="changeNavItem('orders');"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                        print "Orders";
                                                                                                                                                                    } else {
                                                                                                                                                                        print "Pedidos";
                                                                                                                                                                    } ?></a></li>
                                            </ul>
                                            <div class="tab-content pt-3">
                                                <div id="settingsTab" class="tab-pane active">
                                                    <div class="row">
                                                        <div class="col mb-3">

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "First Name";
                                                                                } else {
                                                                                    print "Primeiro nome";
                                                                                } ?></label>
                                                                        <input id="firstnameEdit" class="form-control" type="text" name="firstnameEdit" placeholder="<?= $row["FirstName"] ?>" value="<?= $row["FirstName"] ?>" pattern="[\p{L}\s]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                                print "First name must contain only letters";
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                print "O nome deve conter apenas letras";
                                                                                                                                                                                                                                                            } ?>" oninput="reportValidity();" minlength="1" maxlength="100" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Last Name";
                                                                                } else {
                                                                                    print "Sobrenome";
                                                                                } ?></label>
                                                                        <input id="lastnameEdit" class="form-control" type="text" name="lastnameEdit" placeholder="<?= $row["LastName"] ?>" value="<?= $row["LastName"] ?>" pattern="[\p{L}\s]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                            print "Last name must contain only letters";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                            print "O sobrenome deve conter apenas letras";
                                                                                                                                                                                                                                                        } ?>" oninput="reportValidity();" minlength="1" maxlength="100" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Username";
                                                                                } else {
                                                                                    print "Nome de usuário";
                                                                                } ?></label>
                                                                        <input disabled class="form-control" type="text" placeholder="<?= $row["UserName"] ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input id="emailEdit" class="form-control" type="text" name="emailEdit" placeholder="user@example.com" value="<?= $row["Email"] ?>" required pattern="[^@\s]+@[^@\s]+" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                            print "Invalid email address";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                            print "Endereço de email invalido";
                                                                                                                                                                                                                                                        } ?>" oninput="reportValidity();" minlength="1" maxlength="320">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                var months = <?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];";
                                                                                } else {
                                                                                    print "['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro '];";
                                                                                } ?>;

                                                                selectedDayN = <?php if (!empty($row["DayBirth"])) {
                                                                                    print $row["DayBirth"];
                                                                                } else {
                                                                                    print "-1";
                                                                                }  ?>;


                                                                selectedMonthN = <?php if (!empty($row["MonthBirth"])) {
                                                                                        print $row["MonthBirth"];
                                                                                    } else {
                                                                                        print "-1";
                                                                                    }  ?>;


                                                                selectedYearN = <?php if ($row["YearBirth"] != 0) {
                                                                                    print $row["YearBirth"];
                                                                                } else {
                                                                                    print "-1";
                                                                                }  ?>;


                                                                <?php if ($_SESSION["lang"] == "EN") {
                                                                ?>
                                                                    if (selectedDayN != -1) {
                                                                        var optionDay = '<option id="dayOption" disabled value="day">Day</option>';
                                                                    } else {
                                                                        var optionDay = '<option id="dayOption" selected disabled value="day">Day</option>';
                                                                    }
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    if (selectedDayN != -1) {
                                                                        var optionDay = '<option id="dayOption" disabled value="day">Dia</option>';
                                                                    } else {
                                                                        var optionDay = '<option id="dayOption" selected disabled value="day">Dia</option>';
                                                                    }
                                                                <?php
                                                                } ?>


                                                                <?php if ($_SESSION["lang"] == "EN") {
                                                                ?>
                                                                    if (selectedMonthN != -1) {
                                                                        var optionMonth = '<option disabled value="month">Month</option>';
                                                                    } else {
                                                                        var optionMonth = '<option selected disabled value="month">Month</option>';
                                                                    }
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    if (selectedMonthN != -1) {
                                                                        var optionMonth = '<option disabled value="month">Mês</option>';
                                                                    } else {
                                                                        var optionMonth = '<option selected disabled value="month">Mês</option>';
                                                                    }
                                                                <?php
                                                                } ?>


                                                                <?php if ($_SESSION["lang"] == "EN") {
                                                                ?>
                                                                    if (selectedYearN != -1) {
                                                                        var optionYear = '<option disabled value="year">Year</option>';
                                                                    } else {
                                                                        var optionYear = '<option selected disabled value="year">Year</option>';
                                                                    }
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    if (selectedYearN != -1) {
                                                                        var optionYear = '<option disabled value="year">Ano</option>';
                                                                    } else {
                                                                        var optionYear = '<option selected disabled value="year">Ano</option>';
                                                                    }
                                                                <?php
                                                                } ?>


                                                                <?php if ($_SESSION["lang"] == "EN") {
                                                                ?>
                                                                    var optionDay2 = '<option id="dayOption" selected disabled value="day">Day</option>';
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    var optionDay2 = '<option id="dayOption" selected disabled value="day">Dia</option>';
                                                                <?php
                                                                } ?>


                                                                <?php if ($_SESSION["lang"] == "EN") {
                                                                ?>
                                                                    var optionYear2 = '<option id="dayOption" selected disabled value="day">Day</option>';
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    var optionYear2 = '<option id="dayOption" selected disabled value="day">Dia</option>';
                                                                <?php
                                                                } ?>
                                                            </script>


                                                            <div class="mb-2"><b><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Date of Birth";
                                                                                    } else {
                                                                                        print "Data de nascimento";
                                                                                    } ?></b></div>
                                                            <div class="row mb-2">

                                                                <div class="col-md-3">
                                                                    <select class="form-select" name="daySelect" id="day"></select>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <select class="form-select" name="monthSelect" id="month" onchange="change_month(this)"></select>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <select class="form-select" name="yearSelect" id="year" onchange="change_year(this)"></select>
                                                                </div>

                                                            </div>


                                                            <div class="mb-1"><b><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Address";
                                                                                    } else {
                                                                                        print "Endereço";
                                                                                    } ?></b></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Address line 1";
                                                                                } else {
                                                                                    print "Endereço Linha 1";
                                                                                } ?></label>
                                                                        <input id="Addressline1" class="form-control" type="text" name="Addressline1" placeholder="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                        print "Address line 1";
                                                                                                                                                                    } else {
                                                                                                                                                                        print "Endereço Linha 1";
                                                                                                                                                                    } ?>" value="<?= $row["FirstLineAddress"] ?>" pattern="^[#.0-9a-zA-Z\s,-]+$" oninput="reportValidity();" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                                                        print "Something is wrong with your Address line 1";
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        print "Algo está errado com sua linha de endereço 1";
                                                                                                                                                                                                                                                                                    } ?>" maxlength="255">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group w-50">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Street Number";
                                                                                } else {
                                                                                    print "Número da rua";
                                                                                } ?></label>
                                                                        <input id="StreetNumber" class="form-control" type="text" name="StreetNumber" placeholder="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                        print "Street Number";
                                                                                                                                                                    } else {
                                                                                                                                                                        print "Número da rua";
                                                                                                                                                                    } ?>" value="<?php if ($row["HouseNumber"] != 0) print $row["HouseNumber"];  ?>" pattern="[0-9]+" oninput="reportValidity();" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                                                                                print "Street Number must contain only numbers";
                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                print "O número da rua deve conter apenas números";
                                                                                                                                                                                                                                                                                                            } ?>" maxlength="3">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group" style="width: 48.467%;">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Address line 2";
                                                                                } else {
                                                                                    print "Endereço Linha 2";
                                                                                } ?></label>
                                                                        <input id="Addressline2" class="form-control" type="text" name="Addressline2" placeholder="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                        print "Address line 2";
                                                                                                                                                                    } else {
                                                                                                                                                                        print "Endereço linha 2";
                                                                                                                                                                    } ?>" value="<?= $row["SecondLineAddress"] ?>" pattern="^[#.0-9a-zA-Z\s,-]+$" oninput="reportValidity();" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                                                            print "Something is wrong with your Address line 2";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            print "Algo está errado com sua linha de endereço 2";
                                                                                                                                                                                                                                                                                        } ?>" maxlength="255">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "City";
                                                                                } else {
                                                                                    print "Cidade";
                                                                                } ?></label>
                                                                        <input id="City" class="form-control" type="text" name="City" placeholder="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                        print "City";
                                                                                                                                                    } else {
                                                                                                                                                        print "Cidade";
                                                                                                                                                    } ?>" value="<?= $row["City"] ?>" pattern="^[#.0-9a-zA-Z\s,-]+$" oninput="reportValidity();" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                            print "Something is wrong with your City";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                            print "Algo está errado com sua cidade";
                                                                                                                                                                                                                                                        } ?>" maxlength="50">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group w-50">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Postal Code";
                                                                                } else {
                                                                                    print "Código postal";
                                                                                } ?></label>
                                                                        <input id="PostalCode" class="form-control" type="text" name="PostalCode" placeholder="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                    print "Postal Code";
                                                                                                                                                                } else {
                                                                                                                                                                    print "Código postal";
                                                                                                                                                                } ?>" value="<?= $row["PostalCode"] ?>" pattern="[0-9]+" oninput="reportValidity();" title="<?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                                                                                                                                print "Postal Code must contain only numbers";
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                print "O código postal deve conter apenas números";
                                                                                                                                                                                                                                                            } ?>" maxlength="5">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group" style="width: 48.467%;">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Country";
                                                                                } else {
                                                                                    print "País";
                                                                                } ?></label>
                                                                        <select class="form-select" id="country" name="Country">
                                                                            <?php
                                                                            $sqlStatement = $connection->prepare("SELECT countryId, NameCountry  From AvailableCountries NATURAL JOIN AvailableCountriesNames WHERE IDlang=" . $sqlLang);
                                                                            $sqlStatement->execute();
                                                                            $result = $sqlStatement->get_result();
                                                                            ?>
                                                                            <?php if ($_SESSION["lang"] == "EN") {
                                                                            ?>
                                                                                <option selected disabled hidden value="1">Choose</option>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <option selected disabled hidden value="1">Selecione</option>
                                                                            <?php
                                                                            } ?>

                                                                            <?php

                                                                            while ($row2 = $result->fetch_assoc()) {
                                                                                if ($row2["NameCountry"] != "") {
                                                                            ?>
                                                                                    <option <?php if ($row["countryId"] == $row2["countryId"]) print "selected"; ?> value="<?= $row2["countryId"] ?>"><?= $row2["NameCountry"] ?></option>
                                                                            <?php
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-2"><b><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Civility";
                                                                                    } else {
                                                                                        print "Civilidade";
                                                                                    } ?></b></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input <?php if ($row["Civility"] == "mr") print "checked"; ?> id="mr" type="radio" name="Civility" value="mr">
                                                                    <label for="mr"><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Mr.";
                                                                                    } else {
                                                                                        print "Senhor.";
                                                                                    } ?></label>
                                                                    <input <?php if ($row["Civility"] == "ms") print "checked"; ?> id="ms" type="radio" name="Civility" value="ms">
                                                                    <label for="female"><?php if ($_SESSION["lang"] == "EN") {
                                                                                            print "Ms.";
                                                                                        } else {
                                                                                            print "Senhora.";
                                                                                        } ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <a href="javascript:{}" class="btn btn-primary" onclick="submitSettings();"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                            print "Save Changes";
                                                                                                                                        } else {
                                                                                                                                            print "Salvar alterações";
                                                                                                                                        } ?></a>
                                                            <input type="hidden" name="infoFormInput">
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>


                                                <div id="securityTab" class="tab-pane active" hidden>
                                                    <form method="POST" id="changePSWFform">
                                                        <div class="col-12 col-sm-6 mb-3">
                                                            <div class="mb-2"><b><?php if ($_SESSION["lang"] == "EN") {
                                                                                        print "Change Password";
                                                                                    } else {
                                                                                        print "Mudar senha";
                                                                                    } ?></b></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "Current Password";
                                                                                } else {
                                                                                    print "Senha atual";
                                                                                } ?></label>
                                                                        <input class="form-control" type="password" placeholder="••••••" required name="CurrentPassword" oninput="reportValidity();" required id="CurrentPassword" minlength="7" maxlength="249">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "New Password";
                                                                                } else {
                                                                                    print "Nova Senha";
                                                                                } ?></label>
                                                                        <input class="form-control" type="password" placeholder="••••••" name="PasswordEdit" id="PasswordEdit" oninput="reportValidity();" required minlength="7" maxlength="249">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Confirm <span class="d-none d-xl-inline"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                            print "Password Repeat";
                                                                                                                        } else {
                                                                                                                            print "Repetição de senha";
                                                                                                                        } ?></span></label>
                                                                        <input class="form-control" type="password" placeholder="••••••" name="PasswordRepeatEdit" id="PasswordRepeatEdit" oninput="passwordCheckEdit();" required minlength="7" maxlength="249">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col d-flex justify-content-end">
                                                                <a href="javascript:{}" class="btn btn-primary" type="submit" onclick="changePSW();"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                            print "Update password";
                                                                                                                                                        } else {
                                                                                                                                                            print "Atualizar senha";
                                                                                                                                                        } ?></a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div id="ordersTab" class="tab-pane active" hidden>

                                                    <div class="table-responsive">
                                                        <table class="table align-middle mb-0 bg-white">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th><?php if ($_SESSION["lang"] == "EN") {
                                                                            print "OrderID";
                                                                        } else {
                                                                            print "PedidoID";
                                                                        } ?></th>
                                                                    <th>Status</th>
                                                                    <th><?php if ($_SESSION["lang"] == "EN") {
                                                                            print "Item List";
                                                                        } else {
                                                                            print "Lista de items";
                                                                        } ?></th>
                                                                    <th><?php if ($_SESSION["lang"] == "EN") {
                                                                            print "Order Total";
                                                                        } else {
                                                                            print "Total pedido";
                                                                        } ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sqlStatement2 = $connection->prepare("SELECT * FROM AllorderTotal WHERE UserID=?");
                                                                $sqlStatement2->bind_param("i", $_SESSION["UserID"]);
                                                                $sqlStatement2->execute();
                                                                $result2 = $sqlStatement2->get_result();

                                                                while ($row2 = $result2->fetch_assoc()) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <p class="fw-bold mb-1"><?= $row2["OrderID"] ?></p>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($row2["StatusOrder"] == 0) {
                                                                            ?>
                                                                                <div style="color: red;"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                print "In progress";
                                                                                                            } else {
                                                                                                                print "Em andamento";
                                                                                                            } ?></div>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <div style="color: green;"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                print "Done";
                                                                                                            } else {
                                                                                                                print "Pronto";
                                                                                                            } ?></div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            $sqlStatement = $connection->prepare("SELECT * FROM AllOrderUser WHERE UserID=? AND OrderID=?");
                                                                            $sqlStatement->bind_param("is", $_SESSION["UserID"], $row2["OrderID"]);
                                                                            $sqlStatement->execute();
                                                                            $result = $sqlStatement->get_result();

                                                                            while ($row = $result->fetch_assoc()) {
                                                                            ?>
                                                                                <div><small><?= $row["ProductNameFull"] ?> * <?= $row["QuantityProduct"] ?></small></div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?= $row2["TotalOrder"] ?>€</td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
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
                                            <a class="btn btn-info" onclick="document.getElementById('logoutform').submit();">
                                                <i class="fa fa-sign-out"></i>
                                                <span><?php if ($_SESSION["lang"] == "EN") {
                                                            print "Logout";
                                                        } else {
                                                            print "Sair";
                                                        } ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold"><?php if ($_SESSION["lang"] == "EN") {
                                                                                    print "About";
                                                                                } else {
                                                                                    print "Acerca de";
                                                                                } ?></h6>
                                        <p class="card-text"><?php if ($_SESSION["lang"] == "EN") {
                                                                    print "Contact Info";
                                                                } else {
                                                                    print "Informações de contato";
                                                                } ?>:</p>

                                        <div class="col">
                                            <a class="btn btn-secondary mb-2" href="tel: +33372520234">+33 3 72 52 02 34</a>

                                            <a class="btn btn-secondary mb-2" href="mailto: boutiquethionville@ldlc.com">boutiquethionville@ldlc.com</a>

                                            <a class="btn btn-secondary mb-2" href="https://g.page/LDLC-Thionville?share" target="_blank"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                                                print "Address";
                                                                                                                                            } else {
                                                                                                                                                print "Endereço";
                                                                                                                                            } ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php
        } ?>

    </section>

</body>

</html>