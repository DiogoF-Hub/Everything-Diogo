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
    <nav id="nav">

        <div>
            <a class="aclass <?php if ($ActivePage == "home") print "active1" ?>" href="Home.php"><?= $navitems[0] ?></a>

            <div class="dropdown">
                <div class="dropbtn"><?= $navitems[1] ?></div>
                <div class="dropdown-content">
                    <a href="tel: +33372520234">+33 3 72 52 02 34</a>
                    <a href="mailto: boutiquethionville@ldlc.com">boutiquethionville@ldlc.com</a>
                    <a href="https://g.page/LDLC-Thionville?share" target="_blank">Adress</a>
                </div>
            </div>

            <a class="aclass <?php if ($ActivePage == "products") print "active1" ?>" href="Products.php"><?= $navitems[2] ?></a>
            <a class="aclass <?php if ($ActivePage == "about") print "active1" ?>" href="About.php"><?= $navitems[3] ?></a>
        </div>

        <?php
        if ($_SESSION["userloggedIn"] == false) {
        ?>
            <a class="aclass <?php if ($ActivePage == "logbutton") print "active1" ?>" href="user.php"><?= $navitems[4] ?></a>
        <?php
        } else {
        ?>
            <div> <a style="color: inherit;" href="user.php"><?php if ($_SESSION["lang"] == "EN") print "Hi,";
                                                                else print "Ola," ?> <?= $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></a> </div>
            <form method="POST" id="logoutform">
                <input hidden type="text" name="logoutbutton">
                <a name="logoutbutton" onclick="document.getElementById('logoutform').submit();" class="aclass <?php if ($ActivePage == "logbutton") print "active1" ?>" href="javascript:{}"><?= $navitems[5] ?></a>
            </form>
        <?php
        }
        ?>

        <a class="aclass <?php if ($ActivePage == "chart") print "active1" ?>" href="chart.php">
            <img src="../Images/Shopping-basket.png" alt="" width="45px" height="40px">
        </a>

        <a href="<?= $URL ?>">
            <img src="../Images/Languages.jpg" alt="PT/EN" id="language1">
        </a>

        <a href="Home.php">
            <img src="../Images/Logo.jpg" alt="Logo" width="150px" height="49px">
        </a>
    </nav>
<?php
}

?>