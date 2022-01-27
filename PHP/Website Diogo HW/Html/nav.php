<?php
function navbar($URL, $ActivePage, $toggle, $language)
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
        die("File not found");
    }
?>
    <nav id="nav">

        <div>
            <a class="aclass <?php if ($ActivePage == "home") print "active" ?>" href="Home<?= $language ?>.php"><?= $arraytest[0 + $toggle] ?></a>

            <div class="dropdown">
                <div class="dropbtn"><?= $arraytest[1 + $toggle] ?></div>
                <div class="dropdown-content">
                    <a href="tel: +33372520234">+33 3 72 52 02 34</a>
                    <a href="mailto: boutiquethionville@ldlc.com">boutiquethionville@ldlc.com</a>
                    <a href="https://g.page/LDLC-Thionville?share" target="_blank">Adress</a>
                </div>
            </div>

            <a class="aclass <?php if ($ActivePage == "products") print "active" ?>" href="Products<?= $language ?>.php"><?= $arraytest[2 + $toggle] ?></a>
            <a class="aclass <?php if ($ActivePage == "form") print "active" ?>" href="Form<?= $language ?>.php"><?= $arraytest[3 + $toggle] ?></a>
            <a class="aclass <?php if ($ActivePage == "about") print "active" ?>" href="About<?= $language ?>.php"><?= $arraytest[4 + $toggle] ?></a>
        </div>

        <a href="<?= $URL ?>">
            <img src="../Images/Languages.jpg" alt="PT/EN" id="language1">
        </a>

        <a href="Home<?= $language ?>.php">
            <img src="../Images/Logo.jpg" alt="Logo" width="150px" height="49px">
        </a>
    </nav>
<?php
}

?>