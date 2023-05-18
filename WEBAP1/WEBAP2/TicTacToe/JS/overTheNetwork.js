$(start);

var arr = {};
arr[1] = 'empty';
arr[2] = 'empty';
arr[3] = 'empty';
arr[4] = 'empty';
arr[5] = 'empty';
arr[6] = 'empty';
arr[7] = 'empty';
arr[8] = 'empty';
arr[9] = 'empty';


newMoves = false;


let getNewMovesInterval;




function start() {
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
                    clearInterval(GetGamesInterval);
                    onlineUser = 1;
                    $("#onlineModeChoose2").fadeOut(250);
                    setTimeout(() => {
                        $("#gameTable").fadeIn(650);
                    }, 375);
                    if (isIntervalRunning() == false) {
                        getNewMoves();
                    }
                } else {
                    location.reload();
                }

            }
        });
    });
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
                        '<input hidden value="' + key + '">' +
                        '<button type="button" class="joinbtn btn btn-outline-dark btn-sm">Join</button>' +
                        '</div>' +
                        '</div>');

                    $('#AvailablesGamesContainer').append($template);

                    if (key != Object.keys(parameter)[Object.keys(parameter).length - 1]) {
                        $('#AvailablesGamesContainer').append('<hr>');
                    }
                });

                $(".joinbtn").on("click", function () {
                    JoinFunc(this);
                })

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



function JoinFunc(ButtonClicked) {
    GameID = $(ButtonClicked).parent().children("input").val();

    $.ajax({
        url: "../PHP/API.php",
        type: "POST",
        dataType: 'json',
        data: ({
            joinGame: GameID,
        }),
        success: function (parameter) {
            Message = parameter.Message;

            if (Message == true) {
                clearInterval(GetGamesInterval);
                $(".buttonPlay").attr("disabled", true);
                $("#onlineModeChoose2").fadeOut(250);
                setTimeout(() => {
                    $("#gameTable").fadeIn(650);
                }, 375);

                if (isIntervalRunning() == false) {
                    getNewMoves();
                }
            } else {
                location.reload();
            }

        }
    });
}



function getNewMoves() {
    getNewMovesInterval = setInterval(function () {
        $.ajax({
            url: "../PHP/API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                checkMove: "",
            }),
            success: function (parameter) {
                Message = parameter.Message;

                console.log(Message);

                if (Message == true) {

                    phpArray = parameter.Moves;

                    for (var key in phpArray) {
                        if (phpArray.hasOwnProperty(key)) { //Checks if an object has a property with a specific key
                            if (arr[key] !== phpArray[key]) {
                                //arr[key] = phpArray[key];
                                arr = phpArray;
                                newMoves = true;
                                break;
                            }
                        } else {
                            console.log("2")
                            //location.reload();
                        }
                    }

                    if (newMoves == true) {
                        newMoves = false;
                        updateMoves();

                        if (onlineUser == 1) {
                            onlineUser = 2;
                        }

                        if (onlineUser == 2) {
                            onlineUser = 1;
                        }
                    }

                } else {
                    console.log("1")
                    //location.reload();
                }

            }
        });
    }, 1000);
}


function stopInterval() {
    clearInterval(getNewMovesInterval);
    getNewMovesInterval = undefined;
}


function isIntervalRunning() {
    return getNewMovesInterval !== undefined;
}



function updateMoves() {
    $(".r").removeClass("far fa-circle fa-lg icon");
    $(".r").removeClass("fa fa-times");
    $.each(arr, function (key, value) {
        console.log(value, " ", key);
        if (value == "circle") {
            $(".sq" + key).addClass("far fa-circle fa-lg icon");
        }

        if (value == "cross") {
            $(".sq" + key).addClass("fa fa-times");
        }
    });

    $(".buttonPlay").attr("disabled", false);
}



function sendMove(move) {
    $.ajax({
        url: "../PHP/API.php",
        type: "POST",
        dataType: 'json',
        data: ({
            sendMove: move,
        }),
        success: function (parameter) {
            Message = parameter.Message;

            if (Message != true) {
                console.log("3")
                //location.reload();
            }
        }
    });
}



function checkWinLose() {
    $.ajax({
        url: "../PHP/API.php",
        type: "POST",
        dataType: 'json',
        data: ({
            checkWinLose: "",
        }),
        success: function (parameter) {
            Message = parameter.Message;



        }
    });
}