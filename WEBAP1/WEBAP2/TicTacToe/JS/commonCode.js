$(start);

GameStarted = false;

userLoggedInCheck = 0;
userLoggedIn = false;

existantGames = [];

let GetGamesInterval;

onlineUser = 2;

let myInterval;


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
                userLoggedIn = Message;
            }
        });
    }
    await test();

    return anwser;
}


async function start() {
    $("#onlineModeChoose2").hide();

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
    if (isIntervalRunning() == true) {
        stopInterval();
    }

    GameMode = mode;

    if ($('#gameTable').css('display') == 'none' && GameMode != "online") {
        $("#gameTable").fadeIn(500);
    }

    if ($('#onlineModeChoose2').css('display') != 'none') {
        $("#onlineModeChoose2").fadeOut(1);
    }


    if (GameStarted == true) {
        GameStarted = false;
    }


    $(".btnModal").attr("disabled", true);


    if (GameMode == "online") {
        if (userLoggedIn == false) {
            $("#GameContainer").fadeOut(55);
            $("#sectionTest").fadeIn(1500, 'linear');
        } else {
            GameStarted = true;
            getavailableGames();
            getavailableGamesEvery2s();

            $("#gameTable").fadeOut(250);
            setTimeout(() => {
                $("#onlineModeChoose2").fadeIn(650);
            }, 375);
        }
    } else {
        clearInterval(GetGamesInterval);
    }


    reset();

    setTimeout(() => {
        $(".buttonPlay").attr("disabled", false);
        $(".btnModal").attr("disabled", false);
    }, 375);
}