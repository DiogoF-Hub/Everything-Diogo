$(start);

GameMode = "";

arrPlaces = [1, 2, 3, 4, 5, 6, 7, 8, 9];

var turn = 1;
PlacesTaken = 0;

function start() {
    $("#reset").hide();
    $(".buttonPlay").attr("disabled", true);


    $("#changeModeBtn").bind("click", function () {
        if (GameStarted == true) {
            $("#ButtonContinue").show();
        }
        $('#modal').modal('show');
    });


    $("#ButtonContinue").hide();



    $(".buttonPlay").click(function () {

        //Showing the reset button on the first play
        if (PlacesTaken == 0 && GameMode != 'online') {
            $("#reset").fadeIn(350);
            GameStarted = true;
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


        switch (GameMode) {
            case 'user':
                singlePlayer(this);
                break;
            case 'bot':
                botPlayer(this);
                break;
            case 'online':
                onlinePlayer(this);
                break;
            default:
                alert("Invalid GameMode");
                break;
        }
    });



    $("#reset").bind("click", function () {
        GameStarted = false;
        if (GameMode == "bot") {
            clearTimeout(timeoutId);
        }

        if (isIntervalRunning() == true) {
            stopInterval();
        }

        $(".buttonPlay").attr("disabled", true);
        reset();
    });

}


function onlinePlayer(ButtonClicked) {

    if (onlineUser == 1) {
        $("#screen").text("PLAYER 2 TURN FOLLOWS");

        $(ButtonClicked).addClass("far fa-circle fa-lg icon");

        // Get the class of the button
        buttonClass = $(ButtonClicked).attr("class");
        // Split the class string into an array of substrings
        classArray = buttonClass.split(" ");
        // Find the substring that starts with "sq" and extract the number in front
        numberSQ = classArray.find(function (substring) {
            return substring.startsWith("sq");
        }).substr(2);


        sendMove(numberSQ);


        if (check("far fa-circle fa-lg icon") == true) {//Player 1 won the game
            win("1");
        } else {
            if (PlacesTaken == 9 && check() == "tie") {//check before the bot plays if draw
                draw();
                return;
            }

            PlacesTaken++;
        }

        $(".buttonPlay").attr("disabled", true);
    } else {


        $("#screen").text("PLAYER 1 TURN FOLLOWS");

        $(ButtonClicked).addClass("fa fa-times");

        // Get the class of the button
        buttonClass = $(ButtonClicked).attr("class");
        // Split the class string into an array of substrings
        classArray = buttonClass.split(" ");
        // Find the substring that starts with "sq" and extract the number in front
        numberSQ = classArray.find(function (substring) {
            return substring.startsWith("sq");
        }).substr(2);


        sendMove(numberSQ);


        if (check("fa fa-times") == true) {//Player 1 won the game
            win("1");
        } else {
            if (PlacesTaken == 9 && check() == "tie") {//check before the bot plays if draw
                draw();
                return;
            }

            PlacesTaken++;
        }

        $(".buttonPlay").attr("disabled", true);
    }
}


function botPlayer(ButtonClicked) {
    $(".r").attr("disabled", true);
    $("#screen").text("BOT TURN FOLLOWS");

    $(ButtonClicked).addClass("far fa-circle fa-lg icon");


    // Get the class of the button
    buttonClass = $(ButtonClicked).attr("class");
    // Split the class string into an array of substrings
    classArray = buttonClass.split(" ");
    // Find the substring that starts with "sq" and extract the number in front
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



function singlePlayer(ButtonClicked) {
    if (turn == 1) {//Player1
        $("#screen").text("PLAYER 2 TURN FOLLOWS");

        //Check sign font from font-awesome
        $(ButtonClicked).addClass("far fa-circle fa-lg icon");
        turn = 2;

        if (check("far fa-circle fa-lg icon") == true) {//Player 1 won the game
            win("1");
            return;
        }
    }
    else {
        $("#screen").text("PLAYER 1 TURN FOLLOWS");

        //Cross sign font from font-awesome
        $(ButtonClicked).addClass("fa fa-times");
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
}



function getRandomInt() {
    randomIndex = Math.floor(Math.random() * arrPlaces.length);
    return arrPlaces[randomIndex];
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
    turn = 1;
    PlacesTaken = 0;

    $("#ButtonContinue").hide();

    $("#screen").html("PLAYER 1 TURN FOLLOWS");

    $(".r").removeClass("far fa-circle fa-lg icon");
    $(".r").removeClass("fa fa-times");

    $(".buttonPlay").attr("disabled", false);

    $("#reset").fadeOut(350, 'linear');

    // Reset Colors
    $(".sq1, .sq2, .sq3, .sq4, .sq5, .sq6, .sq7, .sq8, .sq9").css("color", "black");
}



//Function to check the winning move
function check(symbol) {
    if ($(".sq1").hasClass(symbol) && $(".sq2").hasClass(symbol) && $(".sq3").hasClass(symbol)) {
        $(".sq1, .sq2, .sq3").css("color", "green");
        return true;
    } else if ($(".sq4").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq6").hasClass(symbol)) {
        $(".sq4, .sq5, .sq6").css("color", "green");
        return true;
    } else if ($(".sq7").hasClass(symbol) && $(".sq8").hasClass(symbol) && $(".sq9").hasClass(symbol)) {
        $(".sq7, .sq8, .sq9").css("color", "green");
        return true;
    } else if ($(".sq1").hasClass(symbol) && $(".sq4").hasClass(symbol) && $(".sq7").hasClass(symbol)) {
        $(".sq1, .sq4, .sq7").css("color", "green");
        return true;
    } else if ($(".sq2").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq8").hasClass(symbol)) {
        $(".sq2, .sq5, .sq8").css("color", "green");
        return true;
    } else if ($(".sq3").hasClass(symbol) && $(".sq6").hasClass(symbol) && $(".sq9").hasClass(symbol)) {
        $(".sq3, .sq6, .sq9").css("color", "green");
        return true;
    } else if ($(".sq1").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq9").hasClass(symbol)) {
        $(".sq1, .sq5, .sq9").css("color", "green");
        return true;
    } else if ($(".sq3").hasClass(symbol) && $(".sq5").hasClass(symbol) && $(".sq7").hasClass(symbol)) {
        $(".sq3, .sq5, .sq7").css("color", "green");
        return true;
    } else {
        if (PlacesTaken == 9) { //check if the game draw
            return "tie";
        } else {
            return false;
        }
    }
}

