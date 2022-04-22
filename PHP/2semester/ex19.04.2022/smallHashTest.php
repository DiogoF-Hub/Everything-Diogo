<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $pswSignup = "1234";

    $hashPsw = password_hash($pswSignup, PASSWORD_DEFAULT);

    var_dump($hashPsw);

    /* I am done with the SIGNUP */


    /* ON LOGIN */

    $pswLogin = "1234";

    if (password_verify($pswLogin, $hashPsw)) {
        print("Login ok");
    } else {
        print("Not ok");
    }
    ?>
</body>

</html>