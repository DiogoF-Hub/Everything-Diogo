<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <script src="jquery-3.6.3.min.js"></script>

    <script src="Bootstrap/JS bootstrap-5.2.3-dist/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Bootstrap/CSS bootstrap-5.2.3-dist/bootstrap.min5.0.css">


    <link rel="stylesheet" href="fontawesome/css/all.min.css" />

    <script src="myjs.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="mycss.css?t=<?= time(); ?>">

    <script src="confetti.js?t=<?= time(); ?>"></script>
    <title>Tic-Tac-Toe</title>
</head>

<body>
    <div id="modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h3 class="text-center">Choose mode</h3>
                </div>
                <div class="modal-body">
                    <h5 class="mb-4">Choose who you want to play against.</h5>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-robot me-2 icon1"></i>
                        <h6 class="mb-0">You play against the code.</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-friends me-2 icon1"></i>
                        <h6 class="mb-0">You play against a real player.</h6>
                    </div>
                </div>

                <div class="modal-footer d-grid justify-content-center">
                    <button onclick="GameModeFunc('bot')" type="button" class="btn btn-secondary btn-lg mx-2" data-bs-dismiss="modal"><i class="fas fa-robot"></i></button>
                    <button onclick="GameModeFunc('user')" type="button" class="btn btn-primary btn-lg mx-2" data-bs-dismiss="modal"><i class="fas fa-user-friends"></i></button>
                </div>
            </div>
        </div>
    </div>


    <br>
    <div class="container2">
        <div class="overlay text-center"></div>
        <div class="content">
            <div class="d-flex justify-content-center">
                <h1 style="color: white;">TIC-TAC-TOE</h1>
            </div>

            <br><br>

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
                        <button class="buttonPlay sq1 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay sq2 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay sq3 r"></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="buttonPlay sq4 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay sq5 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay sq6 r"></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="buttonPlay sq7 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay sq8 r"></button>
                    </td>
                    <td>
                        <button class="buttonPlay sq9 r"></button>
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