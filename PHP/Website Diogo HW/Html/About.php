<?php
include_once("start.php");
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>About</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("About.php?lang=" . $otherlang, "about", $sqlLang);
    ?>

    <section class="section1">

        <div class="centeraboutbox">
            <div class="divAbout">
                <img src="../Images/Group%20LDLC.PNG" alt="Group LDLC" id="imgabout">

                <hr>
                <?php if ($_SESSION["lang"] == "EN") {
                ?>
                    <div>-The LDLC Group is a French online business group, created in 1996 by Laurent de la Clergerie.</div>
                    <div>-It was ranked 5th in France by FEVAD in 2016.</div>
                    <div>-Its major brand, LDLC.com, is positioned as a major player in online IT and high-tech commerce in France.</div>
                    <div>-Composed of multiple brands including five merchant sites,</div>
                    <div>this business combination combines activities in the field of IT, high-tech or education.</div>
                    <hr>
                    <div>-In addition to the characteristics common to most online sales sites</div>
                    <div>(top sales by category, online product reviews, etc.), the site quickly</div>
                    <div>set up a faceted search to facilitate the search for products such as</div>
                    <div>motherboards, RAMs or monitors whose offer is sometimes in the hundreds of models.</div>
                    <div>-The site also has the particularity of offering computers delivered without</div>
                    <div>a pre-installed operating system.</div>
                <?php
                } else {
                ?>
                    <div>-O "LDLC Group" ?? um grupo de neg??cios online franc??s, criado em 1996 por Laurent de la Clergerie.</div>
                    <div>-Foi classificada em 5?? na Fran??a pela FEVAD em 2016.</div>
                    <div>-Sua principal marca, LDLC.com, est?? posicionada como uma das principais empresas de TI on-line e com??rcio de alta tecnologia na Fran??a.</div>
                    <div>-Composta por v??rias marcas, incluindo cinco sites comerciais,</div>
                    <div>essa combina????o de neg??cios combina atividades nas ??reas de TI, alta tecnologia ou educa????o.</div>
                    <hr>
                    <div>-Al??m das caracter??sticas comuns ?? maioria dos sites de vendas on-line</div>
                    <div>(principais vendas por categoria, an??lises de produtos on-line etc.), o site configurou rapidamente uma</div>
                    <div>uma pesquisa facetada para facilitar a pesquisa de produtos como</div>
                    <div>placas-m??e, RAMs ou monitores cuja oferta ??s vezes ?? as centenas de modelos.</div>
                    <div>-O site tamb??m tem a particularidade de oferecer computadores entregues sem</div>
                    <div>um sistema operacional pr??-instalado.</div>
                <?php
                }
                ?>
            </div>
        </div>

    </section>
</body>

</html>