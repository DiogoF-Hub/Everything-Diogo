<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen" href="../Styling/MyStylesEN.css?t<?= time(); ?>" />
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("HomeEN.php", "home", 5, "PT");
    ?>

    <section class="section1">
        <div class="divHome1">
            <h1 id="homeH1">Website do Diogo</h1>
            <h3>Bem-vindo, este é o meu website:</h3>
            <div>
                Aqui neste website, eu estou vendendo alguns componentes de computador que estao localizadas em
                <a class="texthoverhome" href="../Html/ProductsPT.php">Produtos</a>
            </div>
            <div>Se voce quiser me contactar, voce pode ir em Contacto em cima e clicar em uma das 3 opções</div>
            <div>E se voce quiser saber alguma informação voce pode as encontrar em <a class="texthoverhome" href="../Html/AboutPT.php">Acerca de</a></div>
        </div>



        <div class="iframeHome">

            <div class="iframeMaps">
                <h3>A minha loja é localizada em <span><a class="texthoverhome" href="https://g.page/LDLC-Thionville?share" target="_blank">Thionville, France:</a></span></h3>
                <iframe class="iframe1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2598.681113527863!2d6.137442015692098!3d49.358183879339606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47952549a7427d4f%3A0x82339546d60d9b3e!2sLDLC%20Thionville!5e0!3m2!1spt-PT!2slu!4v1592378624242!5m2!1spt-PT!2slu" frameborder="0"></iframe>
            </div>

            <div class="iframeMaps">
                <a href="https://www.ldlc.com" target="_blank">
                    <img class="ldlcLogo" src="../Images/LDLC%20logo.jpg" alt="LDLC Logo">
                </a>
            </div>

            <div class="iframeMaps">
                <h3>Aqui é um video sobre a nossa loja:</h3>
                <iframe class="iframe1" src="https://www.youtube.com/embed/508s1cz1phs" frameborder="0"></iframe>
            </div>
        </div>



    </section>
</body>

</html>