<?php

session_start(); //start the session

if (!isset($_SESSION["userloggedIn"])) { //check if the $_SESSION["userloggedIn"] is set, and if not creates it and makes it = to false
    $_SESSION["userloggedIn"] = false;
}

//database connection
$host = "localhost";
$user = "root";
$psw = "";
$database = "PIFDatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);
//mysqli_report(MYSQLI_REPORT_OFF); //Used to remove some mysql errors that don't change anything like notices and others, only used while debugging

if ($_SESSION["userloggedIn"] == true) { //if the user is logged in
    $sqlSelectGroupSession = $connection->prepare("SELECT group_id FROM Users WHERE user_id=?"); //Select group_id from the looged in user
    $sqlSelectGroupSession->bind_param("s", $_SESSION["user_id"]); //bind the user id from the session
    $sqlSelectGroupSession->execute();
    $result = $sqlSelectGroupSession->get_result();
    $row = $result->fetch_assoc();

    $_SESSION["group_id"] = $row["group_id"]; //and updating into the session, so if an admin updates the group of a user, the user just needs to refresh the page bcs this will run every time he loads the page

    $sqlSelectGroupRights = $connection->prepare("SELECT * FROM Groups_permissions WHERE group_id=?");
    $sqlSelectGroupRights->bind_param("s", $_SESSION["group_id"]);
    $sqlSelectGroupRights->execute();
    $result2 = $sqlSelectGroupRights->get_result();
    $row2 = $result2->fetch_assoc();

    $_SESSION["group_right_schedule"] = $row2["schedule"];
}

if (isset($_POST["logout"])) { //This runs when the user presses the logout button
    session_destroy(); //This destroys the session
    $_SESSION = array(); //This clears the session array
    header("Location: index.php"); //This makes the user go back to index.php
    die();
}

function nav($ActivePage, $ActiveDropdown) //nav bar function with 2 parameters
//If $ActivePage is = to the one I check down with if statements, I print active1 in the class
//If $ActiveDropdown is = to the one I check down with if statements, I print active1 in the class
{
?>
    <nav id="navboot" class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="../IMAGES/logo.png" alt="Logo" width="150px" height="65px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-1">
                    <li class="nav-item px-4">
                        <a class="nav-link active <?php if ($ActivePage == "home") print "active1" ?>" aria-current="page" href="index.php">Home</a>
                    </li>

                    <li class="nav-item dropdown px-2">
                        <a class="nav-link active dropdown-toggle <?php if ($ActivePage == "profile") print "active1" ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></a>
                        <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item dropdownSelect <?php if ($ActiveDropdown == "profile1") print "active1" ?>" href="profile.php">Edit Profile</a></li>
                            <li><a class="dropdown-item dropdownSelect <?php if ($ActiveDropdown == "profile2") print "active1" ?>" href="myreserventions.php">My Reserventions</a></li>
                        </ul>
                    </li>

                    <?php
                    if ($_SESSION["group_right_schedule"] == 1) {
                    ?>
                        <li class="nav-item px-2">
                            <a class="nav-link active <?php if ($ActivePage == "reservation") print "active1" ?>" aria-current="page" href="reservation.php">Reservation</a>
                        </li>
                    <?php
                    }
                    ?>


                    <?php
                    if ($_SESSION["group_id"] == 2) { //This will only shows if the user is an admin
                    ?>
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link active dropdown-toggle <?php if ($ActivePage == "admin") print "active1" ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                            <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item dropdownSelect <?php if ($ActiveDropdown == "admin1") print "active1" ?>" href="admin_edituser.php">Edit User</a></li>
                                <hr>
                                <li><a class="dropdown-item dropdownSelect <?php if ($ActiveDropdown == "admin2") print "active1" ?>" href="admin_createGroups.php">Create groups</a></li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item px-4">
                        <a class="nav-link active" aria-current="page" href="javascript:{}" onclick="document.getElementById('logoutform').submit();">Logout</a>
                        <form method="POST" id="logoutform" hidden>
                            <input type="text" name="logout">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
}
