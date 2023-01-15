<?php
include_once("commonCodeHTML.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <script src='../JS/jquery-3.6.1.min.js?t=<?= time(); ?>'></script>
    <script src='../JS/commonCode.js?t=<?= time(); ?>'></script>
    <script src='../JS/signInUp.js?t=<?= time(); ?>'></script>
    <script src="../JS/JS bootstrap-5.2.3-dist/bootstrap.bundle.min.js?t=<?= time(); ?>"></script>
    <link rel="stylesheet" href="../CSS/CSS bootstrap-5.2.3-dist/bootstrap.min.css?t=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/fontawesome-free-6.2.1-web/css/all.min.css?t=<?= time(); ?>" />
    <link rel="stylesheet" href="../CSS/main.css?t=<?= time(); ?>">
    <link rel="icon" type="image/x-icon" href="../IMAGES/logo.png">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Datacorp</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>

    <?php
    if (!$_SESSION["userloggedIn"]) {
    ?>
        <br>
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-3">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <div id="signin" class="mx-1 mx-md-4">
                                        <p class="h1 fw-bold mb-3 mx-1 mx-md-3">Sign in</p>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label">Email</label>
                                                <input maxlength="320" type="email" id="emailin" name="emailin" class="form-control" />
                                                <div style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label">Password</label>
                                                <input minlength="8" type="password" id="passwordin" name="passwordin" class="form-control" />
                                                <div style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button id="SigninButton" type="button" class="btn btn-dark btn-lg">Login</button>
                                        </div>

                                    </div>


                                    <div id="signup" class="mx-1 mx-md-4">
                                        <p class="h1 fw-bold mb-3 mx-1 mx-md-3">Sign up</p>

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
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label">Repeat your password</label>
                                                <input minlength="8" type="password" id="passwordRepeat" class="form-control" />
                                                <div style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <select name="BadgeNumber" id="BadgeNumber" class="form-select">
                                                    <option value="-1" selected>Select Badge Number</option>
                                                    <?php
                                                    $sqlStatement = $connection->prepare("SELECT * FROM AvailableBatches");
                                                    $sqlStatement->execute();
                                                    $result = $sqlStatement->get_result();

                                                    while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?= $row["batch_number_id"] ?>"><?= $row["batch_number_id"] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-2 mb-lg-4">
                                            <button id="SignupButton" type="button" class="btn btn-dark btn-lg">Register</button>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="../IMAGES/logo.png" class="img-fluid" alt="Sample image">
                                </div>

                            </div>
                            <div class="text-end">
                                <button id="buttonChange" class="btn btn-secondary btn-lg">Sign
                                    up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else {
        nav("home", 0);
    ?>
        <section class="section1">

            <?php
            if ($_SESSION["group_id"] == 1) {
            ?>
                <div class="container">
                    <div class="row">
                        <h1 class="container d-flex align-items-center justify-content-center text-warning bg-dark mb-0 fw-bolder responsive-font-example">Ask an Admin to give you a group</h1>
                        <h1 class="container d-flex align-items-center justify-content-center text-warning bg-dark fw-bolder responsive-font-example">Then refresh the page</h1>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div id="testh">
                    <h1>Welcome</h1>
                    <h3>This is Home page</h3>
                    <img src="../IMAGES/logo.png" alt="" width="20%" height="20%">
                </div>
            <?php
            }
            ?>


        </section>

    <?php
    } ?>
</body>

</html>