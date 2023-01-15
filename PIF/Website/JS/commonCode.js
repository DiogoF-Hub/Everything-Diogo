let buttonSpinner = $("<span>");
let myspan2 = $("<span>");
myspan2.attr("class", "spinner-border spinner-border-sm");
myspan2.attr("role", "status");
myspan2.attr("aria-hidden", "true");
buttonSpinner.append(myspan2);
buttonSpinner.append("Loading...");

$(startCommon);

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

function checkNames(a) {
    if (!/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ'`'\-]+$/.test(a)) {
        return false;
    }
}


function checkEmail(a) {
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(a)) {
        return false;
    }
}


async function emailtaken(a) {//this is async so just waits until the line 149 as finished that means, tun the whole test func
    let free = true; //flag for the return
    async function test(a) { //func inside a func bcs we need the return    // This one just goes on only after the whole ajax func as finished
        await $.ajax({
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/emailTaken.php",
            type: "POST",
            data: ({
                emailTaken: a,
            }),
            success: function (parameter) {
                bla = parameter.data.Message;

                if (bla == "1") {
                    //$("#email").parent().children("div").html("This email is already taken");
                    free = false;
                }

            },
        });
    }
    await test(a);

    return free;
}

