<?php
include_once("CommonCode.php");

if ($_SESSION["UserLogged"]) {
    header("Location: Home.php");
    die();
}
/* This will run after the form was posted */
if (isset($_POST["FirstName"], $_POST["LastName"], $_POST["email"], $_POST["password"], $_POST["RepeatPassword"], $_POST["BadgeNum"])) {
    $sqlStatement = $connection->prepare("SELECT * FROM Users WHERE user_email=?");
    $sqlStatement->bind_param("s", $_POST["email"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $userExist = $result->num_rows;
    /* end */

    /* This will check if password is ok, if it is it will continue to check the rest of the information. If it isn't well it will "die"(stop) */
    if ($userExist == 0) {

        if ($_POST["password"] === $_POST["RepeatPassword"]) {

            $sqlStatement = $connection->prepare("SELECT RFIDBadge_id FROM Users WHERE RFIDBadge_id=?");
            $sqlStatement->bind_param("s", $_POST["BadgeNum"]);
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            $badgeExist = $result->num_rows;

            if ($badgeExist == 0) {
                $the1 = 1;
                $hashedPSW = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $sqlInsert = $connection->prepare("INSERT INTO Users (firstname, surname, user_email, user_password, RFIDBadge_id, group_id) VALUES(?,?,?,?,?,?)");
                $sqlInsert->bind_param("ssssss", $_POST["FirstName"], $_POST["LastName"], $_POST["email"], $hashedPSW, $_POST["BadgeNum"], $the1);
                $sqlInsert->execute();

                $_SESSION["email"] = $_POST["email"];
                $_SESSION["Name"] = $_POST["FirstName"] . " " . $_POST["LastName"];
                $_SESSION["UserLogged"] = true;

                header("Location: Home.php");
                die();
            } else {
                print "<script>alert('RFIDBadge is already taken!');</script>";
                header("Refresh:0");
                die();
            }
        } else {
            print "<script>alert('Password doesn't match');</script>";
            header("Refresh:0");
            die();
        }
    } else {
        print "<script>alert('User already exists');</script>";
        header("Refresh:0");
        die();
    }
}
// end

// This will check if the sign in options are correct and if they are not it will display the messages in the "else"
if (isset($_POST["emailin"], $_POST["passwordin"])) {
    $sqlStatement = $connection->prepare("SELECT Users.*, Groups_Permissions.admin FROM Users JOIN Groups_Permissions ON users.group_id=Groups_Permissions.group_id WHERE user_email=?");
    $sqlStatement->bind_param("s", $_POST["emailin"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $userExist = $result->num_rows;

    if ($userExist == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($_POST["passwordin"], $row["user_password"])) {
            $_SESSION["email"] = $row["user_email"];
            $_SESSION["Name"] = $row["firstname"] . " " . $row["surname"];
            $_SESSION["UserLogged"] = true;


            header("Location: Home.php");
            die();
        } else {
            print "<script>alert('Password does not match');</script>";
            header("Refresh:0");
            die();
        }
    } else {
        print "<script>alert('User does not exist');</script>";
        header("Refresh:0");
        die();
    }
}
// end

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../JS/jquery-3.6.3.min.js"></script>
    <script src="../JS/main.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <script src="../CSS/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="border border-3 border-primary"></div>
                    <div class="card bg-white shadow-lg">
                        <div class="card-body p-5">



                            <form id="signInForm" method="post" class="mb-3">
                                <h2 class="fw-bold mb-2 text-uppercase ">Sign in</h2>
                                <p class=" mb-5">Please enter your login and password!</p>
                                <div class="mb-3">
                                    <label for="email" class="form-label ">Email address</label>
                                    <input type="email" class="form-control" id="emailin" name="emailin" placeholder="name@example.com">
                                </div>
                                <div class="mb-5">
                                    <label for="password" class="form-label ">Password</label>
                                    <input type="password" class="form-control" id="passwordin" name="passwordin" placeholder="*******">
                                </div>
                                <div class="d-grid">
                                    <button id="signInbtn" class="btn btn-outline-dark" type="button">Login</button>
                                </div>
                            </form>



                            <form id="signUpForm" method="post" class="mb-3">

                                <h2 class=" fw-bold mb-2 text-uppercase">Sign Up</h2>
                                <div class="mb-3">
                                    <label for="text" class="form-label ">First Name</label>
                                    <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="First Name">
                                </div>
                                <div class="mb-3">
                                    <label for="text" class="form-label ">Last Name</label>
                                    <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Last Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label ">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label ">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="*******">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label ">Repeat Password</label>
                                    <input type="password" class="form-control" id="RepeatPassword" name="RepeatPassword" placeholder="*******">
                                </div>
                                <div class="mb-5">
                                    <label for="select" class="form-label ">Badge Number</label>
                                    <select type="select" class="form-control" id="BadgeNum" name="BadgeNum">
                                        <option value="-1" disabled selected>Select your Badge Number</option>
                                        <!-- This will check the badge number in the database and display them by order and it will not show the badge number taken -->
                                        <?php
                                        $sqlStatement = $connection->prepare("SELECT * FROM Badges WHERE RFIDBadge_id NOT IN(SELECT RFIDBadge_id FROM Users) ORDER BY RFIDBadge_id;");
                                        $sqlStatement->execute();
                                        $result = $sqlStatement->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $row["RFIDBadge_id"] ?>"><?= $row["RFIDBadge_id"] ?></option>
                                        <?php
                                        }
                                        ?>
                                        <!-- end -->
                                    </select>

                                </div>
                                <div class="d-grid">
                                    <button id="signUpbtn" class="btn btn-outline-dark" type="button">Sign Up</button>
                                </div>
                            </form>

                            <div>
                                <p id="pchange" class="mb-0  text-center">Don't have an account?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>