$(Start);

SignIn = true;

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

    $("#email").bind("focusout", async function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }


        if (checkEmail($.trim(a)) == false) {
            $(this).parent().children("div").html("Please write a valid Email");
        } else {
            if (await emailtaken(a) == false) {
                $(this).parent().children("div").html("This email is already taken");
            } else {
                $(this).parent().children("div").html("");
            }

        }
    });


    $("#emailin").bind("focusout", function () {
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



    $("#passwordin, #password").bind("focusout", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }

        if (a.length < 8) {
            $(this).parent().children("div").html("The password must contain a minimum of 8 characters");
        } else {
            $(this).parent().children("div").html("");
        }
    });


    $("#BadgeNumber").on("change", function () {
        a = $(this).val();

        if (a == "-1") {
            $(this).parent().children("div").html("Please select a Badge Number");
        } else {
            $(this).parent().children("div").html("");
        }
    });


    $("#passwordRepeat").bind("focusout", function () {
        a = $(this).val();
        b = $("#password").val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }

        if ($.trim(a) !== $.trim(b)) {
            $(this).parent().children("div").html("Please Write the same Password");
        } else {
            $(this).parent().children("div").html("");
        }
    });


    if ($("#logout").length) {
        $("#logout").bind("click", function () {
            $("#logoutForm").submit();
        });
    }


    $("#SigninButton").bind("click", signin);
    $("#SignupButton").bind("click", signup);
    $("#buttonChange").bind("click", changeInUp);

    $("#signup").hide();
}


async function signup() {
    JSvalidation = 0;

    firstName = $("#firstName").val();
    lastName = $("#lastName").val();

    email = $("#email").val();

    password = $("#password").val();
    passwordRepeat = $("#passwordRepeat").val();

    BadgeNumber = $("#BadgeNumber").val();


    if (!firstName) {
        $("#firstName").parent().children("div").html("Please Write something for First Name");
        JSvalidation++;
    } else {
        if (firstName.length < 250) {
            if (checkNames(firstName) == false) {
                $("#firstName").parent().children("div").html("Please write a name with letters");
                JSvalidation++;
            } else {
                $("#firstName").parent().children("div").html("");
            }
        } else {
            $("#firstName").parent().children("div").html("Please write a smaller name");
            JSvalidation++;
        }

    }



    if (!lastName) {
        $("#lastName").parent().children("div").html("Please Write something for Last Name");
        JSvalidation++;
    } else {
        if (lastName.length < 250) {
            if (checkNames(lastName) == false) {
                $("#lastName").parent().children("div").html("Please write a name with letters");
                JSvalidation++;
            } else {
                $("#lastName").parent().children("div").html("");
            }
        } else {
            $("#lastName").parent().children("div").html("Please write a smaller name");
            JSvalidation++;
        }

    }


    if (!email) {
        $("#email").parent().children("div").html("Please Write something for Email");
        JSvalidation++;
    } else {
        if (checkEmail(email) == false) {
            $("#email").parent().children("div").html("Please write a valid Email");
            JSvalidation++;
        } else {
            if (await emailtaken(email) == false) {
                $("#email").parent().children("div").html("This email is already taken");
                JSvalidation++;
            } else {
                $("#email").parent().children("div").html("");
            }
        }
    }


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


    if (password || passwordRepeat) {
        if (password.length < 8) {
            $("#password").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
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
    }


    if (BadgeNumber != "-1") {

    } else {
        $("#BadgeNumber").parent().children("div").html("Please select a Badge Number");
        JSvalidation++;
    }


    if (JSvalidation == 0) {
        $.ajax({
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/SignInUp.php",
            type: "POST",
            data: ({
                firstName: firstName,
                lastName: lastName,
                email: email,
                password: password,
                passwordRepeat: passwordRepeat,
                BadgeNumber: BadgeNumber
            }),
            beforeSend: function () {
                //loading ex
                $("#reload").removeAttr("hidden");
                $("#buttonChange").attr("disabled", true);
            },
            success: function (parameter) {
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            },
            error: function (parameter) {
                // bla = parameter.data.Message;

                // alert(bla);

            }
        });
    }
}




function signin() {
    JSvalidationIn = 0;

    emailin = $("#emailin").val();
    passwordin = $("#passwordin").val();


    if (!emailin) {
        $("#emailin").parent().children("div").html("Please Write something for Email");
        JSvalidationIn++;
    } else {
        if (checkEmail(emailin) == false) {
            $("#emailin").parent().children("div").html("Please write a valid Email");
            JSvalidationIn++;
        } else {
            $("#emailin").parent().children("div").html("");
        }
    }


    if (!passwordin) {
        $("#passwordin").parent().children("div").html("Please Write something for Password");
        JSvalidationIn++;
    } else {
        if (passwordin.length < 8) {
            $("#passwordin").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidationIn++;
        } else {
            $("#passwordin").parent().children("div").html("");
        }
    }

    if (JSvalidationIn == 0) {
        //$("#signin").submit();

        $.ajax({
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/SignInUp.php",
            type: "POST",
            data: ({
                emailin: emailin,
                passwordin: passwordin
            }),
            beforeSend: function () {
                //loading ex
                $("#reload").removeAttr("hidden");
                $("#buttonChange").attr("disabled", true);
            },
            success: function (parameter) {
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            },
            error: function (parameter) {
                bla = parameter.data.Message;
                alert(bla);
            }
        });
    }
}



function changeInUp() {
    if (SignIn == true) {
        SignIn = false;


        $("#signin").hide(400);
        $("#signup").show(400);

        $("#buttonChange").html("Sign in");

        //Remove errors and clearing inputs when changing
        $("#emailin").parent().children("div").html("");
        $("#emailin").val("");
        $("#passwordin").parent().children("div").html("");
        $("#passwordin").val("");
    } else {
        SignIn = true;
        $("#signup").hide(400);
        $("#signin").show(400);


        $("#buttonChange").html("Sign up");

        //Remove errors and clearing inputs when changing
        $("#firstName").parent().children("div").html("");
        $("#firstName").val("");
        $("#lastName").parent().children("div").html("");
        $("#lastName").val("");
        $("#email").parent().children("div").html("");
        $("#email").val("");
        $("#password").parent().children("div").html("");
        $("#password").val("");
        $("#passwordRepeat").parent().children("div").html("");
        $("#passwordRepeat").val("");
        $("#BadgeNumber").parent().children("div").html("");
        $("#BadgeNumber").val("-1");
    }
}
