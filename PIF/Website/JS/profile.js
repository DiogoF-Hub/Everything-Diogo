$(Start);

sessionEmail = "";

function Start() {
    $("#emailProfile").bind("focusout", async function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("Please write an email");
            return;
        }

        if (a != sessionEmail) {
            if (checkEmail($.trim(a)) == false) {
                $(this).parent().children("div").html("Please write a valid Email");
            } else {
                if (await emailtaken(a) == false) {
                    $(this).parent().children("div").html("This email is already taken");
                } else {
                    $(this).parent().children("div").html("");
                }

            }
        }
    });


    $("#firstNameProfile, #lastNameProfile").bind("focusout", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("Please write a name");
            return;
        }

        if (checkNames(a) == false) {
            $(this).parent().children("div").html("Please write a name with letters");
        } else {
            $(this).parent().children("div").html("");
        }

    });
}

