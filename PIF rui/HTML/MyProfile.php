<?php
include_once("CommonCode.php");

if (!$_SESSION["UserLogged"]) {
    header("Location: Login.php");
    die();
}

// This will allow you to change the information that you filled in in the sign up
if (isset($_POST["FirstName"], $_POST["Surname"], $_POST["BadgeNum"])) {

    if (!empty($_POST["FirstName"]) || !empty($_POST["Surname"]) || !empty($_POST["BadgeNum"])) {
        $sqlStatement = $connection->prepare("SELECT * from Users WHERE user_email=?");
        $sqlStatement->bind_param("s", $_SESSION["email"]);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        $userExist = $result->num_rows;

        if ($userExist == 1) {
            $row = $result->fetch_assoc();

            if ($row["RFIDBadge_id"] != $_POST["BadgeNum"]) {
                $sqlStatement = $connection->prepare("SELECT RFIDBadge_id from Users WHERE RFIDBadge_id=?");
                $sqlStatement->bind_param("s", $_POST["BadgeNum"]);
                $sqlStatement->execute();
                $result = $sqlStatement->get_result();
                $badgeExist = $result->num_rows;

                if ($badgeExist == 0) {
                    $sqlUpdate = $connection->prepare("UPDATE Users SET RFIDBadge_id=? WHERE user_email=?");
                    $sqlUpdate->bind_param("ss", $_POST["BadgeNum"], $_SESSION["email"]);
                    $sqlUpdate->execute();
                } else {
                    print "<script>alert('This badge is already taken');</script>";
                    header("Refresh:0");
                    die();
                }
            }


            $sqlUpdate = $connection->prepare("UPDATE Users SET firstname=? WHERE user_email=?");
            $sqlUpdate->bind_param("ss", $_POST["FirstName"], $_SESSION["email"]);
            $sqlUpdate->execute();

            $sqlUpdate = $connection->prepare("UPDATE Users SET surname=? WHERE user_email=?");
            $sqlUpdate->bind_param("ss", $_POST["Surname"], $_SESSION["email"]);
            $sqlUpdate->execute();

            $_SESSION["Name"] = $_POST["FirstName"] . " " . $_POST["Surname"];

            print "<script>alert('Everything is updated');</script>";
            header("Refresh:0");
            die();
        } else {
            print "<script>alert('User does not exist');</script>";
            header("Refresh:0");
            die();
        }
    } else {
        print "<script>alert('Something is empty');</script>";
        header("Refresh:0");
        die();
    }
}
// end

// This will allow you to change the password that you choose in the sign up
if (isset($_POST["currentpassword"], $_POST["Newpassword"], $_POST["NewpasswordRepeat"])) {
    if (!empty($_POST["currentpassword"]) || !empty($_POST["Newpassword"]) || !empty($_POST["NewpasswordRepeat"])) {

        $sqlStatement = $connection->prepare("SELECT user_password from Users WHERE user_email=?");
        $sqlStatement->bind_param("s", $_SESSION["email"]);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        $userExist = $result->num_rows;

        if ($userExist == 1) {
            if ($_POST["Newpassword"] == $_POST["NewpasswordRepeat"]) {
                $row = $result->fetch_assoc();

                if (password_verify($_POST["currentpassword"], $row["user_password"])) {
                    $hashPSW = password_hash($_POST["Newpassword"], PASSWORD_DEFAULT);

                    $sqlUpdate = $connection->prepare("UPDATE Users SET user_password=? WHERE user_email=?");
                    $sqlUpdate->bind_param("ss", $hashPSW, $_SESSION["email"]);
                    $sqlUpdate->execute();

                    print "<script>alert('The password has been updated');</script>";
                    header("Refresh:0");
                    die();
                } else {
                    print "<script>alert('The current password does not match');</script>";
                    header("Refresh:0");
                    die();
                }
            } else {
                print "<script>alert('New Password is not the same as New Password Repeat!');</script>";
                header("Refresh:0");
                die();
            }
        } else {
            print "<script>alert('User does not exist');</script>";
            header("Refresh:0");
            die();
        }
    } else {
        print "<script>alert('Something is empty');</script>";
        header("Refresh:0");
        die();
    }
}
// end
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../JS/jquery-3.6.3.min.js?t=<?= time(); ?>"></script>
    <script src="../JS/ProfilePage.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.3-dist/css/bootstrap.min.css?t=<?= time(); ?>">
    <script src="../CSS/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
</head>

<body>
    <?php
    include_once("Navbar.php");

    $sqlStatement = $connection->prepare("SELECT * from UsersInfo WHERE user_email=?");
    $sqlStatement->bind_param("s", $_SESSION["email"]);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();
    $row = $result->fetch_assoc();
    ?>
    <br><br>
    <div class="container bootstrap snippets bootdey">
        <h1 class="text-primary text-white">Edit Profile</h1>
        <hr>
        <div class="row">
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center">
                    <img src="../Images/avatar.png" class="avatar img-circle img-thumbnail" alt="avatar">
                    <h6 class="text-primary text-white" id="Role" name="Role"><?= $row["group_name"] ?></h6>
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <h3 class="text-primary text-white">Personal info</h3>

                <form id="InfoDisplay" class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">First name:</label>
                        <div class="col-lg-8">
                            <input id="FirstName" name="FirstName" class="form-control" type="text" value="<?= $row["firstname"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Last name:</label>
                        <div class="col-lg-8">
                            <input id="Surname" name="Surname" class="form-control" type="text" value="<?= $row["surname"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email:</label>
                        <div class="col-lg-8">
                            <input disabled class="form-control" type="email" value="<?= $row["user_email"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Badge Number:</label>
                        <div class="col-lg-8">
                            <select id="BadgeNum" name="BadgeNum" class="form-select" type="text">
                                <option value="<?= $row["RFIDBadge_id"] ?>">My badge: <?= $row["RFIDBadge_id"] ?></option>
                                <?php
                                $sqlStatement2 = $connection->prepare("SELECT * FROM BadgesNotTaken");
                                $sqlStatement2->execute();
                                $result2 = $sqlStatement2->get_result();

                                while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                    <option value="<?= $row2["RFIDBadge_id"] ?>"><?= $row2["RFIDBadge_id"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button id="btnEdit" type="button" class="btn btn-light">Edit Profile</button>
                    </div>

                </form>
                <hr>
                <form id="changePSWForm" method="post" class="form-horizontal" role="form">
                    <div class="col-lg-8">
                        <label for="currentpassword" class="form-label ">Current Password:</label>
                        <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="*******">
                    </div>
                    <div class="col-lg-8">
                        <label for="password" class="form-label ">New Password:</label>
                        <input type="password" class="form-control" id="Newpassword" name="Newpassword" placeholder="*******">
                    </div>

                    <div class="col-lg-8">
                        <label for="password" class="form-label ">Repeat New Password:</label>
                        <input type="password" class="form-control" id="NewpasswordRepeat" name="NewpasswordRepeat" placeholder="*******">
                    </div>
                    <br>
                    <div class="form-group">
                        <button class="btn btn-light" type="button" id="btnSavePSW">Change password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <hr>
</body>

</html>