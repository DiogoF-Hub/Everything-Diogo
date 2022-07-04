<?php
function navbar($URL, $ActivePage, $sqlLang)
{
    global $connection;
    $navitems = [];
    $sqlStatement = $connection->prepare("SELECT textDescription from ButtonsNav natural join DescriptionNav where IDLang=" . $sqlLang);
    $sqlStatement->execute();
    $resultnav = $sqlStatement->get_result();
    while ($rownav = $resultnav->fetch_assoc()) {
        array_push($navitems, $rownav["textDescription"]);
    }



?>

    <!-- boot -->

    <nav id="navboot" class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="Home.php">
                <img src="../Images/Logo.jpg" alt="Logo" width="150px" height="49px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-1">
                    <li class="nav-item px-4">
                        <a class="nav-link active <?php if ($ActivePage == "home") print "active1" ?>" aria-current="page" href="Home.php"><?= $navitems[0] ?></a>
                    </li>
                    <li class="nav-item dropdown px-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $navitems[1] ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="tel: +33372520234">+33 3 72 52 02 34</a></li>
                            <hr>
                            <li><a class="dropdown-item" href="mailto: boutiquethionville@ldlc.com">boutiquethionville@ldlc.com</a></li>
                            <hr>
                            <li><a class="dropdown-item" href="https://g.page/LDLC-Thionville?share" target="_blank"><?php if ($_SESSION["lang"] == "EN") {
                                                                                                                            print "Address";
                                                                                                                        } else {
                                                                                                                            print "Endereço";
                                                                                                                        } ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link active <?php if ($ActivePage == "products") print "active1" ?>" aria-current="page" href="Products.php"><?= $navitems[2] ?></a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link active <?php if ($ActivePage == "about") print "active1" ?>" aria-current="page" href="About.php"><?= $navitems[3] ?></a>
                    </li>
                    <?php
                    if ($_SESSION["userloggedIn"] == false) {
                    ?>
                        <li class="nav-item px-5">
                            <a class="nav-link active <?php if ($ActivePage == "logbutton") print "active1" ?>" aria-current="page" href="user.php"><?= $navitems[4] ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item px-5">
                            <a class="nav-link active <?php if ($ActivePage == "user") print "active1" ?>" aria-current="page" href="user.php"><?php if ($_SESSION["lang"] == "EN") print "Hi,";
                                                                                                                                                else print "Ola," ?> <?= $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link active <?php if ($ActivePage == "logbutton") print "active1" ?>" aria-current="page" href="javascript:{}" onclick="document.getElementById('logoutform').submit();"><?= $navitems[5] ?></a>
                            <form method="POST" id="logoutform" hidden>
                                <input type="text" name="logoutbutton">
                            </form>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item px-5">
                        <a class="nav-link active <?php if ($ActivePage == "chart") print "active1" ?>" href="chart.php">
                            <img src="../Images/Shopping-basket.png" alt="" width="45px" height="40px">
                        </a>
                    </li>
                    <li class="nav-item px-5">
                        <a class="nav-link active" href="<?= $URL ?>">
                            <img src="../Images/Languages.jpg" alt="PT/EN" id="language1">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<?php
}

?>