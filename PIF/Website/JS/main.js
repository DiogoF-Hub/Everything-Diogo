$(Start);

function Start() {
    $("#firstName, #lastName").bind("focusout", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }

        if (checkNames(a) == false) {
            $(this).parent().children("div").html("Please write a name with letters");
        } else {
            $(this).parent().children("div").html("");
        }

    });

    $("#email").bind("focusout", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }

        if (checkEmail($.trim(a)) == false) {
            $(this).parent().children("div").html("Please write a valid Email");
        } else {
            $(this).parent().children("div").html("");
        }
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

function signup() {
    JSvalidation = 0;

    firstName = $("#firstName").val();
    lastName = $("#lastName").val();

    email = $("#email").val();

    password = $("#password").val();
    passwordRepeat = $("#passwordRepeat").val();


    if (!firstName) {
        $("#firstName").parent().children("div").html("Please Write something for First Name");
        JSvalidation++;
    } else {
        if (checkNames(firstName) == false) {
            $("#firstName").parent().children("div").html("Please write a name with letters");
            JSvalidation++;
        } else {
            $("#firstName").parent().children("div").html("");
        }
    }



    if (!lastName) {
        $("#lastName").parent().children("div").html("Please Write something for Last Name");
        JSvalidation++;
    } else {
        if (checkNames(lastName) == false) {
            $("#lastName").parent().children("div").html("Please write a name with letters");
            JSvalidation++;
        } else {
            $("#lastName").parent().children("div").html("");
        }
    }


    if (!email) {
        $("#email").parent().children("div").html("Please Write something for Email");
        JSvalidation++;
    } else {
        $("#email").parent().children("div").html("");
    }


    if (!password || !passwordRepeat) {

        if (!password) {
            $("#password").parent().children("div").html("Please Write something for Password");
            JSvalidation++;
        } else {
            $("#password").parent().children("div").html("");
        }


        if (!passwordRepeat) {
            $("#passwordRepeat").parent().children("div").html("Please Write something for Repeat Password");
            JSvalidation++;
        } else {
            $("#passwordRepeat").parent().children("div").html("");
        }


    } else {
        if ($.trim(password) !== $.trim(passwordRepeat)) {
            $("#passwordRepeat").parent().children("div").html("Please Write the same Password");
            $("#password").parent().children("div").html("");
            JSvalidation++;
        } else {
            $("#password").parent().children("div").html("");
            $("#passwordRepeat").parent().children("div").html("");
        }
    }



    if (JSvalidation == 0) {
        //$("#signup").submit();
    }
}
