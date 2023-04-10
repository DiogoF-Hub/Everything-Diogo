$(start);

GameMode = "";

arrPlaces = [1, 2, 3, 4, 5, 6, 7, 8, 9];

var turn = 1;
PlacesTaken = 0;



function start() {

    $("#reset").hide();
    $(".buttonPlay").attr("disabled", true);

    // document.querySelector('#modal .modal-footer button').addEventListener('click', function () {
    //     $('#modal').modal('hide');
    // });

    $('#modal').modal({ backdrop: 'static', keyboard: false }, 'show'); //Modal stays in place until user clicks in of the buttons
    $('#modal').modal('show');


    $(".buttonPlay").click(async function () {

        //Showing the reset button on the first play
        if (PlacesTaken == 0) {
            $("#reset").show(350);
        }

        //Checks if the button was already pressed
        if ($(this).hasClass("fa fa-times") || $(this).hasClass("far fa-circle fa-lg icon")) {
            $(this).css("background-color", "red");
            setTimeout(() => {
                $(this).css("background-color", "white");
            }, 800);
            return;
        }

        PlacesTaken++;


        if (GameMode == "user") {
            if (turn == 1) {//Player1
                $("#screen").text("PLAYER 2 TURN FOLLOWS");

                //Check sign font from font-awesome
                $(this).addClass("far fa-circle fa-lg icon");
                turn = 2;

                if (check("far fa-circle fa-lg icon") == true) {//Player 1 won the game
                    win("1");
                    return;
                }
            }
            else {
                $("#screen").text("PLAYER 1 TURN FOLLOWS");

                //Cross sign font from font-awesome
                $(this).addClass("fa fa-times");
                turn = 1;

                if (check("fa fa-times") == true) {//Player 2 won the game
                    win("2");
                    return;
                }
            }

            if (check() == "tie") {
                draw();
                return;
            }
        } else {
            $(".r").attr("disabled", true);
            $("#screen").text("BOT TURN FOLLOWS");

            $(this).addClass("far fa-circle fa-lg icon");


            // Get the class of the button
            buttonClass = $(this).attr("class");
            // Split the class string into an array of substrings
            classArray = buttonClass.split(" ");
            // Find the substring that starts with "sq" and extract the number
            numberSQ = classArray.find(function (substring) {
                return substring.startsWith("sq");
            }).substr(2);



            indexToRemove = arrPlaces.indexOf(parseInt(numberSQ)); // find the index of the value to remove
            if (indexToRemove !== -1) { // if the value exists in the array
                arrPlaces.splice(indexToRemove, 1); // remove it using splice()
            }
            console.log(arrPlaces);


            if (check("far fa-circle fa-lg icon") == true) {//Player 1 won the game
                win("1");
            } else {

                if (PlacesTaken == 9 && check() == "tie") {//check before the bot plays if draw
                    draw();
                    return;
                }

                PlacesTaken++;

                timeoutId = setTimeout(() => {
                    $("#screen").text("PLAYER 1 TURN FOLLOWS");

                    randomNum = getRandomInt();

                    buttonToPlay = "sq" + randomNum;
                    $("." + buttonToPlay).addClass("fa fa-times")


                    indexToRemove = arrPlaces.indexOf(randomNum); // find the index of the value to remove
                    if (indexToRemove !== -1) { // if the value exists in the array
                        arrPlaces.splice(indexToRemove, 1); // remove it using splice()
                    }


                    console.log("ramdomNumber: " + randomNum);
                    console.log("indexToRemove: " + indexToRemove);
                    console.log(arrPlaces);


                    $(".r").attr("disabled", false);
                }, 1000);

                setTimeout(() => {
                    if (check("fa fa-times") == true) {
                        clearTimeout(timeoutId);
                        win("BOT");
                    }
                }, 1010);
            }
        }
    });


    $("#reset").bind("click", function () {
        if (GameMode == "bot") {
            clearTimeout(timeoutId);
        }
        $(".buttonPlay").attr("disabled", true);
        reset();
    });

}



function getRandomInt() {
    randomIndex = Math.floor(Math.random() * arrPlaces.length);
    return arrPlaces[randomIndex];
}



function GameModeFunc(mode) {
    $(".btnModal").attr("disabled", true);
    if (GameMode == "") {
        GameMode = mode;
    }

    if (GameMode == "online") {
        $.ajax({
            url: "API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                CheckUserLoggedIn: "",
            }),
            success: function (parameter) {
                Message = parameter.Message;

                if (Message == false) {
                    $(".container2").fadeOut(370);
                }
            }
        });

    }

    setTimeout(() => {
        $(".buttonPlay").attr("disabled", false);
    }, 375);
}



function draw() {
    $(".buttonPlay").attr("disabled", true);
    //reset();
    setTimeout(() => {
        alert("Draw");
        reset();
    }, 275);
}



function win(player) {
    $("#screen").text("PLAYER " + player + " WON THE GAME");

    $(".buttonPlay").attr("disabled", true);
    startConfetti();
    if (GameMode == "bot") {
        setTimeout(() => {
            stopConfetti();
            reset();
        }, 2200);
    } else {
        setTimeout(() => {
            stopConfetti();
            reset();
        }, 2200);
    }

}



//reset everything
function reset() {
    arrPlaces = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    $("#screen").text("PLAYER 1 TURN FOLLOWS");
    $("#screen").css("background-color", "transparent");
    $(".r").removeClass("far fa-circle fa-lg icon");
    $(".r").removeClass("fa fa-times");
    $(".buttonPlay").attr("disabled", false);
    turn = 1;
    PlacesTaken = 0;
    $("#reset").hide(350);

    // Reset Colors
    $(".sq1").css("color", "black");
    $(".sq2").css("color", "black");
    $(".sq3").css("color", "black");
    $(".sq4").css("color", "black");
    $(".sq5").css("color", "black");
    $(".sq6").css("color", "black");
    $(".sq7").css("color", "black");
    $(".sq8").css("color", "black");
    $(".sq9").css("color", "black");
}



//Function to check the winning move
function check(symbol) {
    if ($(".sq1").hasClass(symbol) && $(".sq2").hasClass(symbol) && $(".sq3").hasClass(symbol)) {
        $(".sq1").css("color", "green");
        $(".sq2").css("color", "green");
        $(".sq3").css("color", "green");
        return true;
    } else if ($(".sq4").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq6").hasClass(symbol)) {
        $(".sq4").css("color", "green");
        $(".sq5").css("color", "green");
        $(".sq6").css("color", "green");
        return true;
    } else if ($(".sq7").hasClass(symbol) && $(".sq8").hasClass(symbol) && $(".sq9").hasClass(symbol)) {
        $(".sq7").css("color", "green");
        $(".sq8").css("color", "green");
        $(".sq9").css("color", "green");
        return true;
    } else if ($(".sq1").hasClass(symbol) && $(".sq4").hasClass(symbol) && $(".sq7").hasClass(symbol)) {
        $(".sq1").css("color", "green");
        $(".sq4").css("color", "green");
        $(".sq7").css("color", "green");
        return true;
    } else if ($(".sq2").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq8").hasClass(symbol)) {
        $(".sq2").css("color", "green");
        $(".sq5").css("color", "green");
        $(".sq8").css("color", "green");
        return true;
    } else if ($(".sq3").hasClass(symbol) && $(".sq6").hasClass(symbol) && $(".sq9").hasClass(symbol)) {
        $(".sq3").css("color", "green");
        $(".sq6").css("color", "green");
        $(".sq9").css("color", "green");
        return true;
    } else if ($(".sq1").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq9").hasClass(symbol)) {
        $(".sq1").css("color", "green");
        $(".sq5").css("color", "green");
        $(".sq9").css("color", "green");
        return true;
    } else if ($(".sq3").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq7").hasClass(symbol)) {
        $(".sq3").css("color", "green");
        $(".sq5").css("color", "green");
        $(".sq7").css("color", "green");
        return true;
    } else {
        if (PlacesTaken == 9) { //check if the game draw
            return "tie";
        } else {
            return false;
        }
    }

}

