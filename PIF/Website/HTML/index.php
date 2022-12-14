<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src='../JS/jquery-3.6.1.min.js'></script>
    <script src='../JS/main.js'></script>
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="icon" type="image/x-icon" href="../IMAGES/logo.png">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Datacorp</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <br>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">




                                <form method="post" id="signin" class="mx-1 mx-md-4">
                                    <p class="h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign in</p>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">Email</label>
                                            <input maxlength="320" type="email" id="emailin" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>


                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">Password</label>
                                            <input minlength="8" type="password" id="passwordin" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button onclick="signin();" type="button" class="btn btn-dark btn-lg">Login</button>
                                    </div>
                                </form>




                                <form method="post" id="signup" class="mx-1 mx-md-4">
                                    <p class="h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">First Name</label>
                                            <input maxlength="250" type="text" id="firstName" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">Last Name</label>
                                            <input maxlength="250" type="text" id="lastName" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">Email</label>
                                            <input maxlength="320" type="email" id="email" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">Password</label>
                                            <input minlength="8" type="password" id="password" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label">Repeat your password</label>
                                            <input minlength="8" type="password" id="passwordRepeat" class="form-control" />
                                            <div style="color: red;"></div>
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button onclick="signup();" type="button" class="btn btn-dark btn-lg">Register</button>
                                    </div>

                                </form>

                            </div>

                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                <img src="../IMAGES/logo.png" class="img-fluid" alt="Sample image">
                            </div>

                        </div>
                        <div class="text-end">
                            <button id="buttonChange" onclick="changeInUp();" class="btn btn-secondary btn-lg">Sign
                                up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>