<?php
include_once("start.php");

if ($_SESSION["userloggedIn"] == false) {
    print "<script>alert('You are not logged In');</script>";
    print '<script>window.location.href = "user.php";</script>';
    die();
}

if ($_SESSION["UserType"] != "Admin") {
    header("Location: Home.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../Styling/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../Styling/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <link href="../Styling/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../Styling/form-validation.css?t<?= time(); ?>" rel="stylesheet">
    <!--<link rel="icon" href="../Images/Logo.jpg">-->
    <title>Create Product</title>
    <script>
        var loadFile = function(event, output, spanIMG) {
            var spanIMG = document.getElementById("spanIMG");
            var output = document.getElementById('output');

            if (spanIMG.hasAttribute("hidden") == false) {
                spanIMG.setAttribute("hidden", "hidden");
            }

            if (output.hasAttribute("hidden")) {
                output.removeAttribute("hidden");
            }

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("createProduct.php?lang=" . $otherlang, "", $sqlLang);

    if (isset($_POST["ProductName"])) {
        $sqlInsert = $connection->prepare("INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $sqlInsert->bind_param("ssssssssss", $_POST["ProductName"] . ".jpg", $_POST["ProductName"], $_POST["Subtitle1"], $_POST["Subtitle2"], $_POST["company"], $_POST["link"], $_POST["price"], $_POST["Spec1"], $_POST["Spec2"], $_POST["Spec3"]);
    }
    ?>

    <section class="section1">

        <div class="container border border-secondary rounded">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="../Images/product-create.png" alt="" width="72" height="72">
                <h2>Create Product</h2>
            </div>

            <div class="row">
                <div class="col-md order-md-1">
                    <form method="POST">

                        <div class="mb-3">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="Name">Product Name</label>
                                    <input type="text" class="form-control" id="Name" placeholder="AMD Ryzen 7 3800X" required="" name="ProductName">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Subtitle1">Subtitle1</label>
                                    <input type="text" class="form-control" id="Subtitle1" placeholder="8-Core 16-Threads" required="" name="Subtitle1">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Subtitle2">Subtitle2</label>
                                    <input type="text" class="form-control" id="Subtitle2" placeholder="(3.9 GHz / 4.5 GHz)" required="" name="Subtitle2">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="company">Company</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="company" placeholder="AMD" required="" name="company">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="link">Product Link</label>
                            <input type="text" class="form-control" id="link" placeholder="https://www.ldlc.com/fr-lu/fiche/PB00273568.html" name="link">
                        </div>

                        <div class="mb-3">
                            <label for="price">Price</label>
                            <div class="input-group w-25">
                                <input type="number" class="form-control" id="price" placeholder="439" required="" name="price">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="Spec1">Spec 1</label>
                                <input type="text" class="form-control" id="Spec1" placeholder="3.9 Ghz" required="" name="Spec1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="Spec2">Spec 2</label>
                                <input type="text" class="form-control" id="Spec2" placeholder="8" required="" name="Spec2">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="Spec3">Spec 3</label>
                                <input type="text" class="form-control" id="Spec3" placeholder="16" required="" name="Spec3">
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h3 class="mb-3">Descriptions</h3>

                        <div class="col">
                            <h5 class="mb-3">English</h5>
                            <div class="mb-3 w-25">
                                <label for="Description1en">Description 1</label>
                                <input type="text" class="form-control" id="Description1en" placeholder="This is a CPU from" required="" name="Description1en">
                            </div>

                            <div class="mb-3">
                                <label for="Description2en">Description 2</label>
                                <input type="text" class="form-control" id="Description2en" placeholder="Long text explaning the product" required="" name="Description2en">
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="Spec1nameen">Spec 1 Name</label>
                                    <input type="text" class="form-control" id="Spec1nameen" placeholder="Clock" required="" name="Spec1nameen">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Spec2nameen">Spec 2 Name</label>
                                    <input type="text" class="form-control" id="Spec2nameen" placeholder="Cores" required="" name="Spec2nameen">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="Spec3nameen">Spec 3 Name</label>
                                    <input type="text" class="form-control" id="Spec3nameen" placeholder="Threads" required="" name="Spec3nameen">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col">
                            <h5 class="mb-3">Portuguese</h5>
                            <div class="mb-3 w-25">
                                <label for="Description1en">Description 1</label>
                                <input type="text" class="form-control" id="Description1en" placeholder="This is a CPU from" required="" name="Description1en">
                            </div>

                            <div class="mb-3">
                                <label for="Description2en">Description 2</label>
                                <input type="text" class="form-control" id="Description2en" placeholder="Long text explaning the product" required="" name="Description2en">
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="Spec1nameen">Spec 1 Name</label>
                                    <input type="text" class="form-control" id="Spec1nameen" placeholder="Clock" required="" name="Spec1nameen">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Spec2nameen">Spec 2 Name</label>
                                    <input type="text" class="form-control" id="Spec2nameen" placeholder="Cores" required="" name="Spec2nameen">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="Spec3nameen">Spec 3 Name</label>
                                    <input type="text" class="form-control" id="Spec3nameen" placeholder="Threads" required="" name="Spec3nameen">
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">
                        <h3 class="mb-3">Images</h3>

                        <div class="row">
                            <div class="col">
                                <input id="InputFile1" type="file" accept="image/*" onchange="loadFile(event, 'output1', 'spanIMG1')" hidden>
                                <img id="output1" style="height: 135px; width: 135px;" src="../Images/noIMG.jpg">
                                <a class="btn btn-info" style="width: 135px;" href="javascript:{}">First Image</a>
                            </div>
                            <div class="col">
                                <input id="InputFile2" type="file" accept="image/*" onchange="loadFile(event, 'output2', 'spanIMG2')" hidden>
                                <img id="output2" style="height: 135px; width: 135px;" src="../Images/noIMG.jpg">
                                <a class="btn btn-info" style="width: 135px;" href="javascript:{}">Second Image</a>
                            </div>
                            <div class="col">
                                <input id="InputFile3" type="file" accept="image/*" onchange="loadFile(event, 'output3', 'spanIMG3')" hidden>
                                <img id="output3" style="height: 135px; width: 135px;" src="../Images/noIMG.jpg">
                                <a class="btn btn-info" style="width: 135px;" href="javascript:{}">Third Image</a>
                            </div>
                        </div>



                        <br>
                        <button type="submit" href="javascript:{}" class="btn btn-primary btn-lg btn-block">Create Product</button>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>

    </section>
</body>

</html>