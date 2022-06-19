<?php
function navbar($URL, $ActivePage, $togle)
{
    $filename = '../database/database.txt';
    if (file_exists($filename)) {
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            $arraytest = explode(";", $line);
            if (count($arraytest) == 10) {
                break;
            }
        }
    } else {
        die("Nav bar file not found");
    }

    $host = "localhost";
    $user = "root";
    $psw = "";
    $database = "productsdatabase";
    $portNo = 3306;

    $connection = new mysqli($host, $user, $psw, $database, $portNo);

    /*$sqlStatement = $connection->prepare("SELECT * from ButtonsNav natural join DescriptionNav where IDLang=" . $IDlang . $Productsorder);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();*/


?>
    <nav id="nav">

        <div>
            <a class="aclass <?php if ($ActivePage == "home") print "active1" ?>" href="Home.php"><?= $arraytest[0 + $togle] ?></a>

            <div class="dropdown">
                <div class="dropbtn"><?= $arraytest[1 + $togle] ?></div>
                <div class="dropdown-content">
                    <a href="tel: +33372520234">+33 3 72 52 02 34</a>
                    <a href="mailto: boutiquethionville@ldlc.com">boutiquethionville@ldlc.com</a>
                    <a href="https://g.page/LDLC-Thionville?share" target="_blank">Adress</a>
                </div>
            </div>

            <a class="aclass <?php if ($ActivePage == "products") print "active1" ?>" href="Products.php"><?= $arraytest[2 + $togle] ?></a>
            <a class="aclass <?php if ($ActivePage == "about") print "active1" ?>" href="About.php"><?= $arraytest[4 + $togle] ?></a>
        </div>

        <?php
        if (!isset($_SESSION["username"])) {
        ?>
            <a class="aclass <?php if ($ActivePage == "logbutton") print "active1" ?>" href="user.php"><?php if ($_SESSION["lang"] == "EN") print "Login";
                                                                                                        else print "Entrar"; ?></a>
        <?php
        } else {
        ?>
            <div> <a style="color: inherit;" href="user.php"><?php if ($_SESSION["lang"] == "EN") print "Hi,";
                                                                else print "Ola," ?> <?= $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></a> </div>
            <form method="POST" id="logoutform">
                <input hidden type="text" name="logoutbutton">
                <a name="logoutbutton" onclick="document.getElementById('logoutform').submit();" class="aclass <?php if ($ActivePage == "logbutton") print "active1" ?>" href="javascript:{}"><?php if ($_SESSION["lang"] == "EN") print "Logout";
                                                                                                                                                                                                else print "Sair"; ?></a>
            </form>
        <?php
        }
        ?>

        <a class="aclass <?php if ($ActivePage == "chart") print "active1" ?>" href="chart.php">
            <img src="../Images/Shopping-basket.png" alt="" width="45px" height="40px">
        </a>

        <?php
        if (isset($_POST["logoutbutton"])) {
            $chartArrayserialized = serialize($_SESSION["Chart"]);
            $sqlInsert3 = $connection->prepare("UPDATE Users SET Chart=? WHERE UserName=?");
            $sqlInsert3->bind_param("ss", $chartArrayserialized, $_SESSION["username"]);
            $sqlInsert3->execute();

            session_unset();
            session_destroy();
            header('Location: Home.php');
            die();
        }
        ?>

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