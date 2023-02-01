//This is my spinner that I append to the buttons done with bootstrap
let buttonSpinner = $("<span>");
let myspan2 = $("<span>");
myspan2.attr("class", "spinner-border spinner-border-sm");
myspan2.attr("role", "status");
myspan2.attr("aria-hidden", "true");
buttonSpinner.append(myspan2);
buttonSpinner.append("Loading...");

$(startCommon); //This runs when the pages fully loads

function startCommon() {
    // Add slideDown animation to Bootstrap dropdown when expanding with 350ms delay.
    $('.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(350);
    });

    // Add slideUp animation to Bootstrap dropdown when collapsing with 350ms delay.
    $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(350);
    });
}

function checkNames(a) { //This is the function to check if the names are valid within this regex and then I return false if not
    if (!/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ'`'\-]+$/.test(a)) {
        return false;
    }
}


function checkEmail(a) { //This is the function to check if the email are valid within this regex and then I return false if not
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(a)) {
        return false;
    }
}


async function emailtaken(a) {//this is async func, so basically make the ability for me to use await
    let free = true; //flag for the return
    async function test(a) { ///func inside a func bcs we need the return    // This one just goes on only after the whole ajax func as finished
        await $.ajax({
            url: "../PHP/emailTaken.php", //here is the url for the ajax request
            type: "POST", //ajax type
            data: ({ //the name of the post and the variable with the val
                emailTaken: a,
            }),
            success: function (parameter) { //the name of the post and the variable with the val
                bla = parameter.data.Message; //Here I get the message inside the json

                if (bla == "1") { //if the message is = 1 means its taken so I make the variable free = to false
                    free = false;
                }

            },
        });
    }
    await test(a); //Here I used the await so it waits until the ajax its finished to continue, so its doesn't keep going without the ajax has 100% finished

    return free; //and here I return true or false
}


function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n); //return true or false if is numeric
}

