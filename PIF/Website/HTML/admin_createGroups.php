<?php
include_once("commonCodeHTML.php");

if (!$_SESSION["userloggedIn"] || $_SESSION["group_id"] != 2) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
    <script src='../JS/admin_createGroups.js?t=<?= time(); ?>'></script>
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
    nav("admin", "admin2");
    ?>

    <section class="section1">
        <div class="container d-flex justify-content-center pb-4">
            <div class="card mb-4 border border-dark rounded-3">
                <div class="card-body p-4" style="width: 22rem;">
                    <p class="text-center mb-4"><span class="h2">Create Group</span></p>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="groupName">Group Name</label>
                        <input type="text" id="groupName" name="groupName" class="form-control" />
                        <div style="color: red;"></div>
                    </div>


                    <div class="form-outline mb-4 form-switch">
                        <input class="form-check-input" type="checkbox" id="ScheduleSwitch" name="ScheduleSwitch">
                        <label class="form-check-label" for="ScheduleSwitch">Schedule</label>
                    </div>

                    <div class="form-outline mb-4 form-switch">
                        <input class="form-check-input" type="checkbox" id="view_sensitive_dataSwitch" name="view_sensitive_dataSwitch">
                        <label class="form-check-label" for="view_sensitive_dataSwitch">View Sensitive Data</label>
                    </div>

                    <div class="form-outline mb-4 form-switch">
                        <input class="form-check-input" type="checkbox" id="open_door_any_timeSwitch" name="open_door_any_timeSwitch">
                        <label class="form-check-label" for="open_door_any_timeSwitch">Open door at any time</label>
                    </div>

                    <div class="form-outline mb-4 form-switch">
                        <input class="form-check-input" type="checkbox" id="open_door_when_its_availableSwitch" name="open_door_when_its_availableSwitch">
                        <label class="form-check-label" for="open_door_when_its_availableSwitch">Open door when its available</label>
                    </div>


                    <div class="row form-outline">

                        <button id="createGroupBtn" type="button" class="btn btn-info btn-block mb-4 btn-lg">Create</button>

                    </div>

                </div>
            </div>
        </div>
    </section>
</body>

</html>