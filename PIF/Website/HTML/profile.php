<?php
include_once("commonCodeHTML.php"); //Here I include the common code for the pages that users see, thats why its called HTML

if (!$_SESSION["userloggedIn"]) { //Here I check if the user is logged in and if not I will make him go to index.php
    header("Location: index.php");
    die();
}

//Here I get the user data from a create view which joins groups table to get the group name
$sqlSelectUserData = $connection->prepare("SELECT * FROM UserEditProfileJoin WHERE user_id=?");
$sqlSelectUserData->bind_param("s", $_SESSION["user_id"]);
$sqlSelectUserData->execute();
$result = $sqlSelectUserData->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Here I put jquery file, my js and css files, bootstrap files such as css and js and fontawesome css file -->
    <!-- bootstrap & fontawesome are css libraries -->
    <!-- On all js and css files, I have a time stamp that makes the browser thinks that every time it reloads, there is always different files to loads that helps debugging because it doesn't allow the browser to cache the files -->
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
    <script src='../JS/profile.js?t=<?= time(); ?>'></script>
    <script>
        //Here I give php the email and batch_number stored in the session to the js so I can now whenever I need to check if its  valid or taken email or badge
        sessionEmail = "<?= $_SESSION["email"] ?>";
        sessionBadge = "<?= $row["batch_number_id"] ?>";
    </script>
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min5.0.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/fontawesome-free-6.2.1-web/css/all.min.css?t=<?= time(); ?>" />
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <link rel="icon" type="image/x-icon" href="../IMAGES/logo.png">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Datacorp</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <?php
    nav("profile", "profile1"); //Here I call the nav bar function from the commonCodeHTML.php
    ?>
    <section class="section1">
        <div class="container rounded bg-white mb-5 border border-dark rounded-3">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center p-3 py-2">
                        <div class="container2">
                            <?php
                            $ProfileImgPath = "";
                            $toggleRemovePic = "hidden";
                            if ($row["ProfilePic"] == 0) {
                                $ProfileImgPath = "../IMAGES/user.png";
                            } else {
                                print "<script>removePicToggle = true;</script>";
                                $ProfileImgPath = "../IMAGES/ProfilePics/" . $_SESSION["user_id"] . ".jpeg";
                                $toggleRemovePic = "";
                            }
                            ?>
                            <img id="ProfileImg" class="rounded mt-5" src="<?= $ProfileImgPath ?>">
                            <div class="overlayImgBtn rounded mt-5">
                                <button id="buttonPic" class="btn textImgBtn shadow-none">Change</button>
                                <button id="buttonRemovePic" <?= $toggleRemovePic ?> class="btn btn-sm textImgRemovePic shadow-none">Remove</button>
                                <input id="ProfileImgInput" hidden type="file" accept=".png, .jpg, .jpeg">
                            </div>
                        </div>
                        <span id="spanFullNameProfile" class="font-weight-bold"><?= $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></span>
                        <span id="emailSpanProfile" class="text-black-50"><?= $_SESSION["email"] ?></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <form method="POST" id="editProfileForm">
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
                                <div class="row">
                                    <div class="col-md-12"><label class="labels">Email</label>
                                        <input id="emailProfile" name="emailProfile" type="text" class="form-control" placeholder="Email" value="<?= $row["email_id"] ?>">
                                        <div style="color: red;"></div>
                                    </div>
                                </div>

                                <div class="col-md-12"><label class="labels">Badge</label>
                                    <select id="BadgeNumber" name="BadgeNumber" class="form-select">
                                        <option id="badgeOptionID<?= $row["batch_number_id"] ?>" selected value="<?= $row["batch_number_id"] ?>">Your badge: <?= $row["batch_number_id"] ?></option>
                                        <?php
                                        //Here I do a select from a create view that only shows the available batches, the ones that are not taken
                                        $sqlStatement = $connection->prepare("SELECT * FROM AvailableBatches");
                                        $sqlStatement->execute();
                                        $result2 = $sqlStatement->get_result();

                                        while ($row2 = $result2->fetch_assoc()) {
                                        ?>
                                            <option id="badgeOptionID<?= $row2["batch_number_id"] ?>" value="<?= $row2["batch_number_id"] ?>"><?= $row2["batch_number_id"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <div class="row">
                                        <div class="col-md-12"><label class="labels">Group Name</label>
                                            <input type="text" class="form-control" value="<?= $row["group_name"] ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-5 text-center"><button id="saveProfile" class="btn btn-info profile-button" type="button">Save Profile</button></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="p-2 py-3">
                        <div class="d-flex justify-content-between align-items-center experience"><span class="h5">Change your current password</span></div><br>
                        <div class="col-md-12"><label class="labels">Current Password</label><input id="currentPswProfile" type="password" class="form-control" placeholder="Current Password" value="">
                            <div style="color: red;"></div>
                        </div>
                        <div class="col-md-12"><label class="labels">New password</label><input id="newPswProfile" type="password" class="form-control" placeholder="New password" value="">
                            <div style="color: red;"></div>
                        </div>
                        <div class="col-md-12"><label class="labels">Repeat New password</label><input id="newPswRepeatProfile" type="password" class="form-control" placeholder="Repeat New password" value="">
                            <div style="color: red;"></div>
                        </div>
                        <div class="mt-3"><button id="changePswButton" class="btn btn-info profile-button" type="button">Update</button></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
</body>

</html>