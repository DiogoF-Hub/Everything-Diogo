$(start);

var turn = 1;
PlacesTaken = 0;

function start() {

    $("#reset").hide();

    $(".buttonPlay").click(function () {

        //Showing the reset button on the first play
        if (PlacesTaken == 0) {
            $("#reset").show("100");
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

        if (turn == 1) {//Player1
            $("#screen").text("PLAYER 2 TURN FOLLOWS");

            //Check sign font from font-awesome
            $(this).addClass("far fa-circle fa-lg icon");
            turn = 2;

            if (check("far fa-circle fa-lg icon") == true) {//Player 1 won the game
                win();
            }
        }
        else {
            $("#screen").text("PLAYER 1 TURN FOLLOWS");

            //Cross sign font from font-awesome
            $(this).addClass("fa fa-times");
            turn = 1;

            if (check("fa fa-times") == true) {//Player 2 won the game
                win();
            }
        }
    });


    $("#reset").bind("click", function () {
        reset();
    });

}


function win() {
    $(".buttonPlay").attr("disabled", true);
    startConfetti();
    setTimeout(() => {
        stopConfetti();
        reset();
    }, 1500);
}

//reset everything
function reset() {
    $("#screen").text("PLAYER 1 TURN FOLLOWS");
    $("#screen").css("background-color", "transparent");
    $(".r").removeClass("far fa-circle fa-lg icon");
    $(".r").removeClass("fa fa-times");
    turn = 1;
    PlacesTaken = 0;
    $(".buttonPlay").attr("disabled", false);
    $("#reset").hide("100");

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
            $(".buttonPlay").attr("disabled", true);
            setTimeout(() => {
                alert("Draw");
                reset();
            }, 200);
        } else {
            return false;
        }
    }

}

