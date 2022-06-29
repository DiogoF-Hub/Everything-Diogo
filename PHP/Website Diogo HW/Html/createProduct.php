<?php
include_once("start.php");

function InsertPic($picName, $a)
{
    $file_name = preg_replace('/\s+/', '', $_POST["ProductName"]);
    $file_size = $_FILES[$picName]['size'];
    $file_tmp = $_FILES[$picName]['tmp_name'];
    //$file_type = $_FILES[$picName]['type'];
    $arrEXT = explode('.', $_FILES[$picName]['name']);

    $file_ext = strtolower($arrEXT[count($arrEXT) - 1]);
    $extensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $extensions) === false) {
        print "<script>alert('Extension not allowed, please choose a JPEG or PNG file.')</script>";
        header("Refresh:0");
        die();
    }

    if ($file_size > 26214400) {
        print "<script>alert('File size must be less than or 25 MB:')</script>";
        header("Refresh:0");
        die();
    }

    if ($a == 0) { //the first file should have just the name
        $fullFileName = $file_name .  ".jpg";
    } else {
        $fullFileName = $file_name . $a . ".jpg"; //the 2 and the 3 should have the number
    }

    move_uploaded_file($file_tmp, "../Images/" . $fullFileName);
}

if ($_SESSION["userloggedIn"] == false) {
    print "<script>alert('You are not logged In');</script>";
    print '<script>window.location.href = "user.php";</script>';
    die();
}


if ($_SESSION["UserType"] != "Admin") {
    print "<script>alert('You are not an Admin');</script>";
    print '<script>window.location.href = "Home.php";</script>';
    die();
}


if (isset($_POST["Subtitle1"], $_POST["Subtitle2"], $_POST["company"], $_POST["link"], $_POST["price"], $_POST["Spec1"], $_POST["Spec2"], $_POST["Spec3"], $_FILES['ProductPic1'], $_FILES['ProductPic2'], $_FILES['ProductPic3'], $_POST["Description1en"], $_POST["Description2en"], $_POST["Spec1nameen"], $_POST["Spec2nameen"], $_POST["Spec3nameen"], $_POST["Description1pt"], $_POST["Description2pt"], $_POST["Spec1namept"], $_POST["Spec2namept"], $_POST["Spec3namept"]) && $_SESSION["UserType"] = "Admin") {
    //Getting the last used ID then +1 so i can use for the id descriptions
    $sqlID = $connection->prepare("SELECT ProductsID from Products ORDER BY ProductsID DESC LIMIT 1");
    $sqlID->execute();
    $result = $sqlID->get_result();
    $row = $result->fetch_assoc();
    $productID = $row["ProductsID"] + 1; //+1 bcs the next

    //Common product info
    $sqlInsert = $connection->prepare("INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $imgNameFile = preg_replace('/\s+/', '', $_POST["ProductName"]); //remove all types of spaces 
    $sqlInsert->bind_param("ssssssssss", $imgNameFile, $_POST["ProductName"], $_POST["Subtitle1"], $_POST["Subtitle2"], $_POST["company"], $_POST["link"], $_POST["price"], $_POST["Spec1"], $_POST["Spec2"], $_POST["Spec3"]);
    $sqlInsert->execute();

    //English Description
    $sqlInsertEN = $connection->prepare("INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES (?,1,?,?,?,?,?)");
    $sqlInsertEN->bind_param("isssss", $productID, $_POST["Description1en"], $_POST["Description2en"], $_POST["Spec1nameen"], $_POST["Spec2nameen"], $_POST["Spec3nameen"]);
    $sqlInsertEN->execute();

    //Portuguese Description
    $sqlInsertPT = $connection->prepare("INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES (?,2,?,?,?,?,?)");
    $sqlInsertPT->bind_param("isssss", $productID, $_POST["Description1pt"], $_POST["Description2pt"], $_POST["Spec1namept"], $_POST["Spec2namept"], $_POST["Spec3namept"]);
    $sqlInsertPT->execute();


    //3 different files but same code, so for loop
    //$imgARR = ['ProductPic1', 'ProductPic2', 'ProductPic3'];

    InsertPic("ProductPic1", 0);
    InsertPic("ProductPic2", 2);
    InsertPic("ProductPic3", 3);


    print "<script>alert('Product has been created')</script>";
    header("Refresh:0");
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
        var loadFile = function(event, output) {
            var outputID = document.getElementById(output);

            if (outputID.hasAttribute("hidden")) {
                outputID.removeAttribute("hidden");
            }

            outputID.src = URL.createObjectURL(event.target.files[0]);
            outputID.onload = function() {
                URL.revokeObjectURL(outputID.src) // free memory
            }
        };
    </script>
</head>

<body>
    <?php
    include_once("nav.php");
    navbar("createProduct.php?lang=" . $otherlang, "user", $sqlLang);
    ?>

    <section class="section1">
        <div class="container border border-secondary rounded">
            <div class="p-3" style="width: 200px;">
                <div class="e-navlist e-navlist--active-bg">
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link px-2" href="createProduct.php"><i class="fa fa-plus-square mr-1"></i><span> Create Product</span></a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="orders.php"><i class="fa fa-fw fa-th mr-1"></i><span> Orders</span></a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="user.php"><i class="fa fa-undo mr-1"></i><span> Go back</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="py-2 text-center">
                <img class="d-block mx-auto mb-4" src="../Images/product-create.png" alt="" width="72" height="72">
                <h2>Create Product</h2>
            </div>

            <div class="row">
                <div class="col-md order-md-1">
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="Name">Product Name</label>
                                    <input type="text" class="form-control" id="Name" placeholder="AMD Ryzen 7 3800X" name="ProductName" required="">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Subtitle1">Subtitle1</label>
                                    <input type="text" class="form-control" id="Subtitle1" placeholder="8-Core 16-Threads" name="Subtitle1" required="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Subtitle2">Subtitle2</label>
                                    <input type="text" class="form-control" id="Subtitle2" placeholder="(3.9 GHz / 4.5 GHz)" name="Subtitle2" required="">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="company">Company</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="company" placeholder="AMD" name="company" required="">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="link">Product Link</label>
                            <input type="text" class="form-control" id="link" placeholder="https://www.ldlc.com/fr-lu/fiche/PB00273568.html" name="link" required="">
                        </div>

                        <div class="mb-3">
                            <label for="price">Price</label>
                            <div class="input-group w-25">
                                <input type="number" class="form-control" id="price" placeholder="439" name="price" required="">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="Spec1">Spec 1</label>
                                <input type="text" class="form-control" id="Spec1" placeholder="3.9 Ghz" name="Spec1" required="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="Spec2">Spec 2</label>
                                <input type="text" class="form-control" id="Spec2" placeholder="8" name="Spec2" required="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="Spec3">Spec 3</label>
                                <input type="text" class="form-control" id="Spec3" placeholder="16" name="Spec3" required="">
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h3 class="mb-3">Descriptions</h3>

                        <div class="col">
                            <h5 class="mb-3">English</h5>
                            <div class="mb-3 w-25">
                                <label for="Description1en">Description 1</label>
                                <input type="text" class="form-control" id="Description1en" placeholder="This is a CPU from" name="Description1en" required="">
                            </div>

                            <div class="mb-3">
                                <label for="Description2en">Description 2</label>
                                <input type="text" class="form-control" id="Description2en" placeholder="Long text explaning the product" name="Description2en" required="">
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="Spec1nameen">Spec 1 Name</label>
                                    <input type="text" class="form-control" id="Spec1nameen" placeholder="Clock" name="Spec1nameen" required="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Spec2nameen">Spec 2 Name</label>
                                    <input type="text" class="form-control" id="Spec2nameen" placeholder="Cores" name="Spec2nameen" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="Spec3nameen">Spec 3 Name</label>
                                    <input type="text" class="form-control" id="Spec3nameen" placeholder="Threads" name="Spec3nameen" required="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col">
                            <h5 class="mb-3">Portuguese</h5>
                            <div class="mb-3 w-25">
                                <label for="Description1en">Description 1</label>
                                <input type="text" class="form-control" id="Description1en" placeholder="This is a CPU from" name="Description1pt" required="">
                            </div>

                            <div class="mb-3">
                                <label for="Description2en">Description 2</label>
                                <input type="text" class="form-control" id="Description2en" placeholder="Long text explaning the product" name="Description2pt" required="">
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="Spec1nameen">Spec 1 Name</label>
                                    <input type="text" class="form-control" id="Spec1nameen" placeholder="Clock" name="Spec1namept" required="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Spec2nameen">Spec 2 Name</label>
                                    <input type="text" class="form-control" id="Spec2nameen" placeholder="Cores" name="Spec2namept" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="Spec3nameen">Spec 3 Name</label>
                                    <input type="text" class="form-control" id="Spec3nameen" placeholder="Threads" name="Spec3namept" required="">
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">
                        <h3 class="mb-3">Images</h3>


                        <div class="row mb-5">
                            <div class="col d-flex flex-column">
                                <input class="mx-auto" id="InputFile1" type="file" accept="image/*" onchange="loadFile(event, 'output1')" hidden name="ProductPic1" required="">
                                <img class="mx-auto rounded" id="output1" style="height: 135px; width: 135px;" src="../Images/noIMG.jpg">
                                <a class="btn btn-info mx-auto mt-1" style="width: 135px;" href="javascript:{}" onclick="document.getElementById('InputFile1').click();">First Image</a>
                            </div>
                            <div class="col d-flex flex-column">
                                <input class="mx-auto" id="InputFile2" type="file" accept="image/*" onchange="loadFile(event, 'output2')" hidden name="ProductPic2" required="">
                                <img class="mx-auto rounded" id="output2" style="height: 135px; width: 135px;" src="../Images/noIMG.jpg">
                                <a class="btn btn-info mx-auto mt-1" style="width: 135px;" href="javascript:{}" onclick="document.getElementById('InputFile2').click();">Second Image</a>
                            </div>
                            <div class="col d-flex flex-column">
                                <input class="mx-auto" id="InputFile3" type="file" accept="image/*" onchange="loadFile(event, 'output3')" hidden name="ProductPic3" required="">
                                <img class="mx-auto rounded" id="output3" style="height: 135px; width: 135px;" src="../Images/noIMG.jpg">
                                <a class="btn btn-info mx-auto mt-1" style="width: 135px;" href="javascript:{}" onclick="document.getElementById('InputFile3').click();">Third Image</a>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary btn-lg btn-block">Create Product</button>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>

    </section>
</body>

</html>