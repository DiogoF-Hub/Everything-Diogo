$(start);

GameStarted = false;

userLoggedInCheck = 0;
userLoggedIn = false;

existantGames = [];

let GetGamesInterval;


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

function getavailableGames() {
    $.ajax({
        url: "../PHP/API.php",
        type: "POST",
        dataType: 'json',
        data: ({
            getavailableGames: "",
        }),
        success: function (parameter) {
            var existantGamesJSON = JSON.stringify(existantGames);
            var phpArrayJSON = JSON.stringify(parameter);

            // compare the two strings
            if (existantGamesJSON !== phpArrayJSON) {
                existantGames = parameter;
                console.log("not the same");
                $('#AvailablesGamesContainer').html("");
                $.each(parameter, function (key, value) {
                    var $template = $('<div class="row justify-content-between">' +
                        '<div class="col">' +
                        '<div class="d-inline-block">GameID: <span class="fw-bold">' + key + '</span></div>' +
                        '</div>' +
                        '<div class="col">' +
                        '<div class="d-inline-block">Session: <span class="fw-bold">' + value + '</span></div>' +
                        '</div>' +
                        '<div class="col">' +
                        '<button type="button" class="btn btn-outline-dark btn-sm">Join</button>' +
                        '</div>' +
                        '</div>');

                    $('#AvailablesGamesContainer').append($template);

                    if (key != Object.keys(parameter)[Object.keys(parameter).length - 1]) {
                        $('#AvailablesGamesContainer').append('<hr>');
                    }
                });
            } else {
                console.log("the same");
            }
        }

    });
}

function getavailableGamesEvery2s() {
    GetGamesInterval = setInterval(() => {
        getavailableGames();
    }, 2000);
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



    $("#CreateGameBTN").bind("click", function () {
        $.ajax({
            url: "../PHP/API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                createGame: "",
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