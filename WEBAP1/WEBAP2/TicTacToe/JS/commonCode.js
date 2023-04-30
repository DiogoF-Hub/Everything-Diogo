$(start);

GameStarted = false;

userLoggedInCheck = 0;
userLoggedIn = false;


async function checkUserLoggedIn() {
    let anwser = false;
    async function test() {
        await $.ajax({
            url: "../PHP/API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                CheckUserLoggedIn: "",
            }),
            success: function (parameter) {
                Message = parameter.Message;
                anwser = Message;
            }
        });
    }
    await test();

    return anwser;
}


async function start() {
    $('#modal').modal({ backdrop: 'static', keyboard: false }, 'show'); //Modal stays in place until user clicks in one of the buttons
    $('#modal').modal('show');


    if (await checkUserLoggedIn() == true) {
        userLoggedIn = true;
        $("#logoutButton").show();
    } else {
        $("#logoutButton").hide();
    }



    $("#logoutButton").bind("click", function () {
        $("#logoutButton").attr("disabled", true);
        $.ajax({
            url: "../PHP/API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                logout: "",
            }),
            success: function (parameter) {
                Message = parameter.Message;

                if (Message == true) {
                    $("#logoutButton").fadeOut(350);
                    userLoggedInCheck = 0;
                    userLoggedIn = false;
                }

                $("#logoutButton").attr("disabled", false);
            }
        });
    });
}


async function GameModeFunc(mode) {

    if (GameStarted == true) {
        GameStarted = false;
        $("#ButtonContinue").hide();
    }

    $(".btnModal").attr("disabled", true);

    GameMode = mode;


    if (GameMode == "online" && userLoggedInCheck == 0) {
        if (userLoggedIn == false) {
            if (await checkUserLoggedIn() == false) {
                $(".container2").fadeOut(55);
                $("#sectionTest").fadeIn(1500, 'linear');
            } else {
                userLoggedIn = true;
                $("#logoutButton").show();
            }
        }
    }

    reset();

    setTimeout(() => {
        $(".buttonPlay").attr("disabled", false);
        $(".btnModal").attr("disabled", false);
    }, 375);
}