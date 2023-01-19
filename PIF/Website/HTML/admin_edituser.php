<?php
include_once("commonCodeHTML.php"); //Here I include the common code for the pages that users see, thats why its called HTML

//Here I check if the user is logged and if yes, if he is an admin
if (!$_SESSION["userloggedIn"] || $_SESSION["group_id"] != 2) {
    header("Location: index.php");
    die();
}

/*Here I do the select to get the group info once and push into an array*/
$arrGroups = [];

$sqlGroups = $connection->prepare("SELECT group_id, group_name FROM groups_permissions WHERE group_id!=2");
$sqlGroups->execute();
$result = $sqlGroups->get_result();
while ($row = $result->fetch_assoc()) {
    $arrGroups += [$row["group_id"] => $row["group_name"]];
}

//select to get all the user data that are not admin
$sqlAdminUsers = $connection->prepare("SELECT * FROM Users WHERE group_id!=2");
$sqlAdminUsers->execute();
$result2 = $sqlAdminUsers->get_result();
$numberofUsers2 = $result2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Here I put jquery file, my js and css files, bootstrap files such as css and js and fontawesome css file -->
    <!-- bootstrap & fontawesome are css libraries -->
    <!-- On all js and css files, I have a time stamp that makes the browser thinks that every time it reloads, there is always different files to loads that helps debugging because it doesn't allow the browser to cache the files -->
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
    <script src='../JS/admin_edituser.js?t=<?= time(); ?>'></script>
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
    nav("admin", "admin1"); //Here I call the nav bar function from the commonCodeHTML.php
    ?>

    <section class="section1">

        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <p><span class="h2">User Management</span></p>

                    <div class="card mb-4 border border-dark rounded-3">
                        <div class="card-body p-4 w-100">

                            <?php
                            $LoopsBreake = 0; //I define this variable = 0 so I can count when it will be the last user so i don't print the hr
                            while ($row2 = $result2->fetch_assoc()) { //while is used to get user by user, or row by row and repeat the code inside
                                $LoopsBreake++; //this is make the variable + 1

                                //every row there is me printing the user data
                            ?>
                                <div id="formUser<?= $row2["user_id"] ?>">
                                    <div class="row align-items-center">
                                        <div class="col d-flex justify-content-center mb-5">
                                            <img src="../IMAGES/user.png" class="img-fluid w-75 h-75" alt="">
                                        </div>
                                        <div class="col d-flex justify-content-center mb-5">
                                            <div>
                                                <p class="small text-muted mb-1">First Name</p>
                                                <p class="lead fw-normal mb-0"><?= $row2["firstname"] ?></p>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center mb-5">
                                            <div>
                                                <p class="small text-muted mb-1">Last Name</p>
                                                <p class="lead fw-normal mb-0"><?= $row2["lastname"] ?></p>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center mb-5">
                                            <div>
                                                <p class="small text-muted mb-1">Email</p>
                                                <p class="lead fw-normal mb-0"><?= $row2["email_id"] ?></p>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center mb-5">
                                            <div>
                                                <p class="small text-muted mb-1">Badge Number</p>
                                                <p class="lead fw-normal mb-0"><?= $row2["batch_number_id"] ?></p>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center mb-5">
                                            <div>
                                                <p class="small text-muted mb-1">Group</p>
                                                <select id="selectAdmin<?= $row2["user_id"] ?>" name="groupAdmin" class="form-select">
                                                    <?php
                                                    //here I use the arr that I create on top, so I dont repeat the same select to get the same data
                                                    foreach ($arrGroups as $key => $value) {
                                                    ?>
                                                        <option <?php /*If its the same I print selected so it makes the option selected when the page loads*/ if ($row2["group_id"] == $key) {
                                                                    print "selected";
                                                                } ?> value="<?= $key ?>"><?= $value ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center mb-5">
                                            <div>
                                                <button id="saveAdminBtn<?= $row2["user_id"] ?>" class="lead btn btn-primary mt-4 buttonSave" type="button">Save</button>
                                                <input type="text" hidden value="<?= $row2["user_id"] ?>"> <!-- Here I use this hidden input to identify which user I clicked -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($LoopsBreake != $numberofUsers2) { //As I said on top, I check if its the last user so I dont print the hr using the result of num rows from the select
                                ?>
                                    <hr>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </section>
</body>

</html>