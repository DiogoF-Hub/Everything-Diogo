<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <script src="jquery-3.6.3.min.js"></script>

    <script src="Bootstrap/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="Bootstrap/CSS bootstrap-5.2.3-dist/bootstrap.min5.0.css?t=<?= time(); ?>">


    <link rel="stylesheet" href="fontawesome/css/all.min.css" />

    <script src="myjs.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="mycss.css?t=<?= time(); ?>">

    <script src="confetti.js?t=<?= time(); ?>"></script>
    <title>Tic-Tac-Toe</title>
</head>

<body>
    <br>
    <div class="container2">
        <div class="overlay text-center"></div>
        <div class="content">
            <!-- Heading -->
            <div class="d-flex justify-content-center">
                <h1 style="color: white;">TIC-TAC-TOE</h1>
            </div>
            <br>
            <br>
            <div class="text-center">

                <!-- Inform area for player's turn -->
                <h4 id="screen" style="color: white;">
                    PLAYER 1 TURN FOLLOWS
                </h4>
            </div>
            <br>

            <!-- Playing Canvas -->
            <table class="d-flex justify-content-center">
                <tr>
                    <td colspan="3">
                </tr>
                <tr>
                    <td>
                        <button class="buttonPlay shadow-none sq1 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay shadow-none sq2 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay shadow-none sq3 r"></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="buttonPlay shadow-none sq4 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay shadow-none sq5 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay shadow-none sq6 r"></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="buttonPlay shadow-none sq7 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay shadow-none sq8 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay shadow-none sq9 r"></button>
                    </td>
                </tr>
            </table>
            <br><br>
            <div class="d-flex justify-content-center">
                <button id="reset" class="reset btn btn-lg btn-danger">Reset</button>
            </div>
        </div>
    </div>
</body>

</html>