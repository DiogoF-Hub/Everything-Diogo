<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Formulário</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("FormEN.php", "form", 5, "PT");
    ?>


    <section class="section1">

        <div class="divform">
            <form action="EndPT.php" id="flex1">
                <label class="label1">Primeiro nome:</label>
                <input>
                <label class="label1">Ultimo nome:</label>
                <input>
                <label class="label1">Aniversário:</label>
                <input type="date">
                <label class="label1">Email:</label>
                <input>
                <label class="label1">Endereço:</label>
                <input placeholder="Endereço linha 1">
                <input placeholder="Endereço linha 2 (opcional)">
                <input placeholder="Código postal">
                <input placeholder="Cidade">
                <input placeholder="País">
                <label class="label1">CV e LM</label>
                <input type="file" accept=".docx, .pdf, .doc" multiple>
                <div>----</div>
                <input type="submit" value="Submeter" id="submit">
            </form>
        </div>
    </section>
</body>

</html>