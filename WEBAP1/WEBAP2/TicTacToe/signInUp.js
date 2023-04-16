$(start);

sign = 1;


var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})



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



function checkUsername(a) {
    if (!/^[A-Za-z0-9_-]+$/.test(a)) {
        return false;
    }
}



async function usernameTaken(a) {
    let free = true;
    async function test(a) {
        await $.ajax({
            url: "API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                usernameTaken: a,
            }),
            success: function (parameter) {
                Message = parameter.Message;
                free = Message;
            }
        });
    }
    await test(a);

    return free;
}



async function emailTaken(a) {
    let free = true;
    async function test(a) {
        await $.ajax({
            url: "API.php",
            type: "POST",
            dataType: 'json',
            data: ({
                emailTaken: a,
            }),
            success: function (parameter) {
                Message = parameter.Message;
                free = Message;
            }
        });
    }
    await test(a);

    return free;
}



function start() {

    $("#usernameInputUp").tooltip();

    $("#sectionTest").hide();
    $("#signUpInput").hide();

    $("#changeSign").bind("click", function () {
        $("#emailUsernameInputIn").parent().children("div").html("");
        $("#passwordInputIn").parent().children("div").html("");

        $("#emailUsernameInputIn").val("");
        $("#passwordInputIn").val("");

        $("#firstNameInputUp").parent().children("div").html("");
        $("#lastNameInputUp").parent().children("div").html("");
        $("#usernameInputUp").parent().children("div").html("");
        $("#emailInputUp").parent().children("div").html("");
        $("#passwordInputUp").parent().children("div").html("");
        $("#passwordRepeatInputUp").parent().children("div").html("");

        $("#firstNameInputUp").val("");
        $("#lastNameInputUp").val("");
        $("#usernameInputUp").val("");
        $("#emailInputUp").val("");
        $("#passwordInputUp").val("");
        $("#passwordRepeatInputUp").val("");

        if (sign == 1) {
            $("#signInInput").hide(350);
            $("#signUpInput").show(350);

            $("#SignButton").html("Sign up");
            $("#changeSign").html("Sign in");
            $("#changeSign").parent().children("p").html("Already registerd?");

            sign = 0;
        } else {
            $("#signUpInput").hide(350);
            $("#signInInput").show(350);

            $("#SignButton").html("Sign in");
            $("#changeSign").html("Sign up");
            $("#changeSign").parent().children("p").html("Dont have an account yet?");

            sign = 1;
        }

    });


    $("#SignButton").bind("click", async function () {
        checksbol = true;
        if (sign == 1) {
            emailUsernameIn = $("#emailUsernameInputIn");
            passwordIn = $("#passwordInputIn");

            if (emailUsernameIn.val() === "") {
                emailUsernameIn.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (emailUsernameIn.val().length < 3) {
                    emailUsernameIn.parent().children("div").html("This field must have a length of 3 characters");
                    checksbol = false;
                } else {
                    emailUsernameIn.parent().children("div").html("");
                }
            }

            if (passwordIn.val() === "") {
                passwordIn.parent().children("div").html("The password must be filled");
                checksbol = false;
            } else {
                if (passwordIn.val().length < 6) {
                    passwordIn.parent().children("div").html("The password must have a length of 6 characters");
                    checksbol = false;
                } else {
                    passwordIn.parent().children("div").html("");
                }
            }


            if (checksbol == true) {
                alert("gay");
            }
        } else {
            firstNameInputUp = $("#firstNameInputUp");
            lastNameInputUp = $("#lastNameInputUp");

            usernameInputUp = $("#usernameInputUp");

            emailInputUp = $("#emailInputUp");

            passwordInputUp = $("#passwordInputUp");
            passwordRepeatInputUp = $("#passwordRepeatInputUp");


            if (firstNameInputUp.val() === "") {
                firstNameInputUp.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (checkNames(firstNameInputUp.val()) == false) {
                    firstNameInputUp.parent().children("div").html("Name must only contain letters");
                    checksbol = false;
                } else {
                    firstNameInputUp.parent().children("div").html("");
                }
            }


            if (lastNameInputUp.val() === "") {
                lastNameInputUp.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (checkNames(lastNameInputUp.val()) == false) {
                    lastNameInputUp.parent().children("div").html("Name must only contain letters");
                    checksbol = false;
                } else {
                    lastNameInputUp.parent().children("div").html("");
                }
            }


            if (usernameInputUp.val() === "") {
                usernameInputUp.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (checkUsername(usernameInputUp.val()) == false) {
                    usernameInputUp.parent().children("div").html("Username must be: A-Z a-z 0-9 - _");
                    checksbol = false;
                } else {
                    if (usernameInputUp.val().length < 3 || usernameInputUp.val().length > 15) {
                        usernameInputUp.parent().children("div").html("Username must be 3-15 characters long");
                        checksbol = false;
                    } else {
                        if (await usernameTaken(usernameInputUp.val()) == true) {
                            usernameInputUp.parent().children("div").html("This username is already being used");
                            checksbol = false;
                        } else {
                            usernameInputUp.parent().children("div").html("");
                        }
                    }
                }
            }


            if (emailInputUp.val() === "") {
                emailInputUp.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (checkEmail(emailInputUp.val()) == false) {
                    emailInputUp.parent().children("div").html("The email is not valid");
                    checksbol = false;
                } else {
                    if (await emailTaken(emailInputUp.val()) == true) {
                        emailInputUp.parent().children("div").html("This email is already being used");
                        checksbol = false;
                    } else {
                        emailInputUp.parent().children("div").html("");
                    }
                }
            }


            if (passwordInputUp.val() === "") {
                passwordInputUp.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (passwordInputUp.val().length < 6) {
                    passwordInputUp.parent().children("div").html("The password must be 6 characters long");
                    checksbol = false;
                } else {
                    passwordInputUp.parent().children("div").html("");
                }
            }


            if (passwordRepeatInputUp.val() === "") {
                passwordRepeatInputUp.parent().children("div").html("This field must be filled");
                checksbol = false;
            } else {
                if (passwordRepeatInputUp.val().length < 6) {
                    passwordRepeatInputUp.parent().children("div").html("The password must be 6 characters long");
                    checksbol = false;
                } else {
                    if (passwordInputUp.val() !== passwordRepeatInputUp.val()) {
                        passwordRepeatInputUp.parent().children("div").html("The password is not the same");
                        checksbol = false;
                    } else {
                        passwordRepeatInputUp.parent().children("div").html("");
                    }
                }
            }


            if (checksbol == true) {
                alert("gay");
            }
        }
    });



    $("#firstNameInputUp").on("focusout input", function () {
        firstNameInputUp = $("#firstNameInputUp");
        if (firstNameInputUp.val() === "") {
            firstNameInputUp.parent().children("div").html("This field must be filled");
        } else {
            if (checkNames(firstNameInputUp.val()) == false) {
                firstNameInputUp.parent().children("div").html("Name must only contain letters");
            } else {
                firstNameInputUp.parent().children("div").html("");
            }
        }
    });



    $("#lastNameInputUp").on("focusout input", function () {
        lastNameInputUp = $("#lastNameInputUp");
        if (lastNameInputUp.val() === "") {
            lastNameInputUp.parent().children("div").html("This field must be filled");
        } else {
            if (checkNames(lastNameInputUp.val()) == false) {
                lastNameInputUp.parent().children("div").html("Name must only contain letters");
            } else {
                lastNameInputUp.parent().children("div").html("");
            }
        }
    });



    $("#usernameInputUp").on("focusout input", async function () {
        usernameInputUp = $("#usernameInputUp");
        if (usernameInputUp.val() === "") {
            usernameInputUp.parent().children("div").html("This field must be filled");
        } else {
            if (checkUsername(usernameInputUp.val()) == false) {
                usernameInputUp.parent().children("div").html("Username must be: A-Z a-z 0-9 - _");
            } else {
                if (usernameInputUp.val().length < 3 || usernameInputUp.val().length > 15) {
                    usernameInputUp.parent().children("div").html("Username must be 3-15 characters long");
                } else {
                    if (await usernameTaken(usernameInputUp.val()) == true) {
                        usernameInputUp.parent().children("div").html("This username is already being used");
                    } else {
                        usernameInputUp.parent().children("div").html("");
                    }
                }
            }
        }
    });



    $("#emailInputUp").on("focusout input", async function () {
        emailInputUp = $("#emailInputUp");
        if (emailInputUp.val() === "") {
            emailInputUp.parent().children("div").html("This field must be filled");
        } else {
            if (checkEmail(emailInputUp.val()) == false) {
                emailInputUp.parent().children("div").html("The email is not valid");
            } else {
                if (await emailTaken(emailInputUp.val()) == true) {
                    emailInputUp.parent().children("div").html("This email is already being used");
                    checksbol = false;
                } else {
                    emailInputUp.parent().children("div").html("");
                }
            }
        }
    });



    $("#passwordInputUp").on("focusout input", function () {
        passwordInputUp = $("#passwordInputUp");
        if (passwordInputUp.val() === "") {
            passwordInputUp.parent().children("div").html("This field must be filled");
        } else {
            if (passwordInputUp.val().length < 6) {
                passwordInputUp.parent().children("div").html("The password must be 6 characters long");
            } else {
                passwordInputUp.parent().children("div").html("");
            }
        }
    });



    $("#passwordRepeatInputUp").on("focusout input", function () {
        passwordInputUp = $("#passwordInputUp");
        passwordRepeatInputUp = $("#passwordRepeatInputUp");
        if (passwordRepeatInputUp.val() === "") {
            passwordRepeatInputUp.parent().children("div").html("This field must be filled");
        } else {
            if (passwordRepeatInputUp.val().length < 6) {
                passwordRepeatInputUp.parent().children("div").html("The password must be 6 characters long");
            } else {
                if (passwordInputUp.val() !== passwordRepeatInputUp.val()) {
                    passwordRepeatInputUp.parent().children("div").html("The password is not the same");
                } else {
                    passwordRepeatInputUp.parent().children("div").html("");
                }
            }
        }
    });





    $("#emailUsernameInputIn").on("focusout input", function () {
        emailUsernameIn = $("#emailUsernameInputIn");
        if (emailUsernameIn.val() === "") {
            emailUsernameIn.parent().children("div").html("This field must be filled");
        } else {
            if (emailUsernameIn.val().length < 3) {
                emailUsernameIn.parent().children("div").html("This field must have a length of 3 characters");
            } else {
                emailUsernameIn.parent().children("div").html("");
            }
        }
    });



    $("#passwordInputIn").on("focusout input", function () {
        passwordIn = $("#passwordInputIn");
        if (passwordIn.val() === "") {
            passwordIn.parent().children("div").html("The password must be filled");
        } else {
            if (passwordIn.val().length < 6) {
                passwordIn.parent().children("div").html("The password must have a length of 6 characters");
            } else {
                passwordIn.parent().children("div").html("");
            }
        }
    });
}