<?php
include_once("../PHP/API.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../IMAGES/icon.png">
    <script src="../JS/jquery-3.6.3.min.js"></script>

    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min.css">

    <link rel="stylesheet" href="../CSS/fontawesome/css/all.min.css" />

    <script src="../JS/signInUp.js?t=<?= time(); ?>"></script>

    <script src="../JS/game.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/mycss.css?t=<?= time(); ?>">

    <script src="../JS/confetti.js?t=<?= time(); ?>"></script>
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
                    <h5 class="mb-4">Choose who you want to play against:</h5>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-robot me-2 icon1"></i>
                        <h6 class="mb-0"><span> &zwnj; </span>You play against the code.</h6>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-user-friends me-2 icon1"></i>
                        <h6 class="mb-0"><span> &zwnj; </span>You play against a real player on the same computer.</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-globe me-2 icon1 globeText"></i>
                        <h6 class="mb-0"><span> &zwnj; </span>You play against a real player over the network.</h6>
                    </div>
                </div>
                <div class="modal-footer d-grid justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <button onclick="GameModeFunc('bot')" type="button" class="btn btn-secondary btn-lg mx-2 btnModal" data-bs-dismiss="modal"><i class="fas fa-robot"></i></button>
                                <button onclick="GameModeFunc('user')" type="button" class="btn btn-primary btn-lg mx-2 btnModal" data-bs-dismiss="modal"><i class="fas fa-user-friends"></i></button>
                                <button onclick="GameModeFunc('online')" type="button" class="btn btn-success btn-lg mx-2 btnModal" data-bs-dismiss="modal"><i class="fas fa-thin fa-globe globeButton"></i></button>
                            </div>
                        </div>
                    </div>
                    <button id="ButtonContinue" type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Continue <i class="fas fa-thin fa-arrow-right-to-bracket"></i></button>
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

            <div class="text-center">
                <button id="changeModeBtn" type="button" class="btn btn-sm btn-outline-light">Change game mode</button>
            </div>

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


    <div id="sectionTest">
        <section class="text-center">
            <div class="card mx-auto" style="max-width: 500px;">
                <div class="card-body">

                    <div class="row d-flex justify-content-center">
                        <div class="d-flex justify-content-end">
                            <button id="returnGame" type="button" class="btn btn-sm btn-outline-dark">Return <i class="fas fa-thin fa-arrow-right-to-bracket"></i></button>
                        </div>
                        <div class="col-lg-10">

                            <div id="signInInput">
                                <h2 class="fw-bold mb-5">Sign in</h2>
                                <div class="form-floating mb-4">
                                    <input type="email" id="emailUsernameInputIn" class="form-control mx-auto" placeholder="1" />
                                    <label class="form-label" for="emailInputUp">Email address / Username</label>
                                    <div style="color: red;"></div>
                                </div>


                                <div class="form-floating mb-4">
                                    <input type="password" id="passwordInputIn" class="form-control mx-auto" placeholder="1" />
                                    <label class="form-label" for="passwordInputIn">Password</label>
                                    <div style="color: red;"></div>
                                </div>
                            </div>




                            <div id="signUpInput">
                                <h2 class="fw-bold mb-5">Sign up</h2>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating">
                                            <input type="text" id="firstNameInputUp" class="form-control mx-auto" placeholder="1" />
                                            <label class="form-label" for="firstNameInputUp">First name</label>
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating">
                                            <input type="text" id="lastNameInputUp" class="form-control mx-auto" placeholder="1" />
                                            <label class="form-label" for="lastNameInputUp">Last name</label>
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="text" maxlength="15" id="usernameInputUp" class="form-control mx-auto" placeholder="1" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="The Username must be: &lt;br&gt; 3-15 characters long &lt;br&gt; a-z  A-Z  0-9 and  -  _" />
                                    <label class="form-label" for="usernameInputUp">Username</label>
                                    <div style="color: red;"></div>
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="email" id="emailInputUp" class="form-control mx-auto" placeholder="1" autocomplete="off" />
                                    <label class="form-label" for="emailInputUp">Email address</label>
                                    <div style="color: red;"></div>
                                </div>


                                <div class="form-floating mb-4">
                                    <input type="password" id="passwordInputUp" class="form-control mx-auto" placeholder="1" />
                                    <label class="form-label" for="passwordInputUp">Password</label>
                                    <div style="color: red;"></div>
                                </div>


                                <div class="form-floating mb-4">
                                    <input type="password" id="passwordRepeatInputUp" class="form-control mx-auto" placeholder="1" />
                                    <label class="form-label" for="passwordRepeatInputUp">Repeat Password</label>
                                    <div style="color: red;"></div>
                                </div>


                            </div>



                            <button id="SignButton" class="btn btn-primary btn-block mb-2">Sign In</button>



                            <hr>



                            <div class="text-center">
                                <p>Dont have an account yet?</p>
                                <button id="changeSign" type="button" class="btn btn-outline-info">Sign Up</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</body>

</html>