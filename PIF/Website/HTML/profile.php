<?php
include_once("commonCodeHTML.php");

if (!$_SESSION["userloggedIn"]) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src='../JS/jquery-3.6.1.min.js'></script>
    <script src='../JS/commonCode.js'></script>
    <script src='../JS/profile.js'></script>
    <script>
        sessionEmail = "<?= $_SESSION["email"] ?>";
    </script>
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min5.0.css">
    <link rel="stylesheet" href="../CSS/fontawesome-free-6.2.1-web/css/all.min.css" />
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="icon" type="image/x-icon" href="../IMAGES/logo.png">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Datacorp</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <?php
    nav("profile", "profile1");

    $sqlSelectUserData = $connection->prepare("SELECT * FROM Users WHERE email_id=?");
    $sqlSelectUserData->bind_param("s", $_SESSION["email"]);
    $sqlSelectUserData->execute();
    $result = $sqlSelectUserData->get_result();
    $row = $result->fetch_assoc()
    ?>

    <section class="section1">
        <div class="container rounded bg-white mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="../IMAGES/profile.jpg">
                        <span class="font-weight-bold"><?= $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></span>
                        <span class="text-black-50"><?= $_SESSION["email"] ?></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <form method="POST">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="text-right">Profile Settings</h3>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6"><label class="labels">First Name</label>
                                    <input id="firstNameProfile" name="firstNameProfile" type="text" class="form-control" placeholder="First Name" value="<?= $row["firstname"] ?>">
                                    <div style="color: red;"></div>
                                </div>

                                <div class="col-md-6"><label class="labels">Last Name</label>
                                    <input id="lastNameProfile" name="lastNameProfile" type="text" class="form-control" placeholder="Last Name" value="<?= $row["lastname"] ?>">
                                    <div style="color: red;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="col-md-12"><label class="labels">Email</label>
                                    <input id="emailProfile" name="emailProfile" type="text" class="form-control" placeholder="Email" value="<?= $row["email_id"] ?>">
                                    <div style="color: red;"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"><label class="labels">Country Code</label>
                                        <input id="CountryCodeProfile" name="CountryCodeProfile" type="text" class="form-control" placeholder="Country Code" value="<?php if ($row["phoneNumber"] != 0) {
                                                                                                                                                                        print $row["phoneNumber"];
                                                                                                                                                                    } ?>">
                                        <div style="color: red;"></div>
                                    </div>
                                    <div class="col-md-9"><label class="labels">Mobile Number</label>
                                        <input id="PhoneNumberProfile" name="PhoneNumberProfile" type="number" class="form-control" placeholder="Mobile Number" value="<?php if ($row["phoneNumber"] != 0) {
                                                                                                                                                                            print $row["phoneNumber"];
                                                                                                                                                                        } ?>">
                                        <div style="color: red;"></div>
                                    </div>
                                </div>

                                <div class="col-md-12"><label class="labels">Badge</label>
                                    <select id="BadgeNumber" name="BadgeNumber" class="form-select">
                                        <option selected value="<?= $row["batch_number_id"] ?>">Your badge: <?= $row["batch_number_id"] ?></option>
                                        <?php
                                        $sqlStatement = $connection->prepare("SELECT * FROM AvailableBatches");
                                        $sqlStatement->execute();
                                        $result2 = $sqlStatement->get_result();

                                        while ($row2 = $result2->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $row2["batch_number_id"] ?>"><?= $row2["batch_number_id"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div style="color: red;"></div>
                                </div>

                            </div>
                            <div class="mt-5 text-center"><button id="saveProfile" class="btn btn-info profile-button" type="button">Save Profile</button></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="p-2 py-3">
                        <div class="d-flex justify-content-between align-items-center experience"><span class="h5">Change your current password</span></div><br>
                        <div class="col-md-12"><label class="labels">Current Password</label><input type="text" class="form-control" placeholder="Current Password" value=""></div>
                        <div class="col-md-12"><label class="labels">New password</label><input type="text" class="form-control" placeholder="New password" value=""></div>
                        <div class="col-md-12"><label class="labels">Repeat New password</label><input type="text" class="form-control" placeholder="Repeat New password" value=""></div>
                        <div class="mt-3"><button class="btn btn-info profile-button" type="button">Update</button></div>
                    </div>

                    <div class="p-2 py-3">

                        <div class="d-flex justify-content-between align-items-center experience"><span class="h5">Verify Email</span></div><br>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Email Code</label><input type="text" class="form-control" placeholder="Email Code" value=""></div>
                            <div class="col-md-6">
                                <div class="mt-4 text-center"><button class="btn btn-link profile-button" type="button">Resend Code</button></div>
                            </div>
                        </div>
                        <div class="mt-3"><button class="btn btn-info profile-button" type="button">Verify Email</button></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
</body>

</html>