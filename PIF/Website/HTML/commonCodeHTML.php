<?php

session_start();

if (!isset($_SESSION["userloggedIn"])) {
    $_SESSION["userloggedIn"] = false;
}

$host = "localhost";
$user = "root";
$psw = "";
$database = "PIFDatabase";
$portNo = 3306;

$connection = new mysqli($host, $user, $psw, $database, $portNo);
//mysqli_report(MYSQLI_REPORT_OFF);


if (isset($_POST["logout"])) {
    session_destroy();
    $_SESSION = array();
    header("Refresh:0");
    die();
}

function nav($ActivePage, $ActiveDropdown)
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
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item dropdownSelect <?php if ($ActiveDropdown == "profile1") print "active1" ?>" href="profile.php">Edit Profile</a></li>
                            <hr>
                            <li><a class="dropdown-item dropdownSelect <?php if ($ActiveDropdown == "profile2") print "active1" ?>" href="#">Check your reservations</a></li>
                        </ul>
                    </li>

                    <li class="nav-item px-2">
                        <a class="nav-link active dropdownSelect <?php if ($ActivePage == "reservation") print "active1" ?>" aria-current="page" href="#">Reservation</a>
                    </li>

                    <?php
                    if ($_SESSION["group_id"] == 2) {
                    ?>
                        <li class="nav-item px-2">
                            <a class="nav-link active dropdownSelect <?php if ($ActivePage == "admin") print "active1" ?>" aria-current="page" href="#">Admin</a>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item px-4">
                        <a class="nav-link active dropdownSelect <?php if ($ActivePage == "logbutton") print "active1" ?>" aria-current="page" href="javascript:{}" onclick="document.getElementById('logoutform').submit();">Logout</a>
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
