$(Start);

sessionEmail = "";

firstNameProfileAjax = "";
lastNameProfileAjax = "";
emailProfileAjax = "";
BadgeNumberProfileAjax = "";

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


    $("#currentPswProfile, #newPswProfile").bind("focusout", function () {
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

    $("#newPswRepeatProfile").bind("focusout", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }

        if (a.length < 8) {
            $(this).parent().children("div").html("The password must contain a minimum of 8 characters");
        } else {
            b = $("#newPswProfile").val();

            if ($.trim(a) !== $.trim(b)) {
                $(this).parent().children("div").html("The passwords dont match");
            } else {
                $(this).parent().children("div").html("");
            }
        }
    });


    $("#saveProfile").bind("click", saveProfile);
    $("#changePswButton").bind("click", changePsw);
}


async function saveProfile() {
    JSvalidation = 0;

    firstNameProfile = $("#firstNameProfile").val();
    lastNameProfile = $("#lastNameProfile").val();
    emailProfile = $("#emailProfile").val();
    BadgeNumber = $("#BadgeNumber").val();


    if (!firstNameProfile) {
        $("#firstNameProfile").parent().children("div").html("Please Write something for First Name");
        JSvalidation++;
    } else {
        if (firstNameProfile.length < 255) {
            if (checkNames(firstNameProfile) == false) {
                $("#firstNameProfile").parent().children("div").html("Please write a name with letters");
                JSvalidation++;
            } else {
                $("#firstNameProfile").parent().children("div").html("");
            }
        } else {
            $("#firstNameProfile").parent().children("div").html("Please write a smaller name");
            JSvalidation++;
        }

    }


    if (!lastNameProfile) {
        $("#lastNameProfile").parent().children("div").html("Please Write something for First Name");
        JSvalidation++;
    } else {
        if (lastNameProfile.length < 255) {
            if (checkNames(lastNameProfile) == false) {
                $("#lastNameProfile").parent().children("div").html("Please write a name with letters");
                JSvalidation++;
            } else {
                $("#lastNameProfile").parent().children("div").html("");
            }
        } else {
            $("#lastNameProfile").parent().children("div").html("Please write a smaller name");
            JSvalidation++;
        }

    }


    if (!emailProfile) {
        $("#emailProfile").parent().children("div").html("Please Write something for Email");
        JSvalidation++;
    } else {

        if (checkEmail(emailProfile) == false) {
            $("#emailProfile").parent().children("div").html("Please write a valid Email");
            JSvalidation++;
        } else {
            if (emailProfile != sessionEmail && await emailtaken(emailProfile) == false) {
                $("#emailProfile").parent().children("div").html("This email is already taken");
                JSvalidation++;
            } else {
                $("#emailProfile").parent().children("div").html("");
            }
        }

    }

    if (sessionBadge == BadgeNumber) {
        BadgeNumber = -1;
    }

    if (JSvalidation == 0) {
        $.ajax({
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/EditProfile.php",
            type: "POST",
            data: ({
                firstNameProfile: firstNameProfile,
                lastNameProfile: lastNameProfile,
                emailProfile: emailProfile,
                BadgeNumber: BadgeNumber
            }),
            beforeSend: function () {
                //loading ex
                $("#firstNameProfile").attr("disabled", true);
                $("#lastNameProfile").attr("disabled", true);
                $("#emailProfile").attr("disabled", true);
                $("#BadgeNumber").attr("disabled", true);
                $("#saveProfile").attr("disabled", true);

                $("#saveProfile").html("");

                $("#saveProfile").append(buttonSpinner);
            },
            success: function (parameter) {
                bla = parameter.data.Message;
                if (bla != "1") {
                    alert(bla);
                }

                setTimeout(function () {
                    $("#firstNameProfile").attr("disabled", false);
                    $("#lastNameProfile").attr("disabled", false);
                    $("#emailProfile").attr("disabled", false);
                    $("#BadgeNumber").attr("disabled", false);
                    $("#saveProfile").attr("disabled", false);

                    if (BadgeNumber != "-1") {
                        $("#badgeOptionID" + BadgeNumber).html("Your badge: " + BadgeNumber);
                        $("#badgeOptionID" + sessionBadge).html("");
                        $("#badgeOptionID" + sessionBadge).append(sessionBadge);
                        sessionBadge = BadgeNumber;
                    }

                    if (sessionEmail != emailProfile) {
                        $("#emailSpanProfile").html(emailProfile);
                        sessionEmail = emailProfile;
                    }


                    $("#spanFullNameProfile").html(firstNameProfile + " " + lastNameProfile);
                    $("#navbarDropdown").html(firstNameProfile + " " + lastNameProfile);

                    $("#saveProfile").html("Save Profile");
                }, 1000);

            },
            error: function (parameter) {
                bla = parameter.data.Message;
                alert(bla);
            }
        });
    }
}




function changePsw() {
    JSvalidation = 0;

    currentPsw = $("#currentPswProfile").val();
    newPsw = $("#newPswProfile").val();
    newPswRepeat = $("#newPswRepeatProfile").val();

    if (!currentPsw) {
        $("#currentPswProfile").parent().children("div").html("Please write something for Password");
        JSvalidation++;
    } else {
        if (currentPsw.length < 8) {
            $("#currentPswProfile").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
        }
    }


    if (!newPsw) {
        $("#newPswProfile").parent().children("div").html("Please write something for Password");
        JSvalidation++;
    } else {
        if (newPsw.length < 8) {
            $("#newPswProfile").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
        }
    }


    if (!newPswRepeat) {
        $("#newPswRepeatProfile").parent().children("div").html("Please write something for Password");
        JSvalidation++;
    } else {
        if (newPswRepeat.length < 8) {
            $("#newPswRepeatProfile").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
        }
    }


    if (newPsw !== newPswRepeat) {
        $("#newPswRepeatProfile").parent().children("div").html("The passwords dont match");
        JSvalidation++;
    }

    if (JSvalidation == 0) {
        $.ajax({
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/EditProfile.php",
            type: "POST",
            data: ({
                currentPsw: currentPsw,
                newPsw: newPsw,
                newPswRepeat: newPswRepeat
            }),
            beforeSend: function () {
                //loading ex
                $("#currentPswProfile").attr("disabled", true);
                $("#newPswProfile").attr("disabled", true);
                $("#newPswRepeatProfile").attr("disabled", true);

                $("#changePswButton").attr("disabled", true);

                $("#changePswButton").html("");

                $("#changePswButton").append(buttonSpinner);
            },
            success: function (parameter) {
                bla = parameter.data.Message;
                if (bla != "1") {
                    alert(bla);
                }
                setTimeout(function () {
                    $("#currentPswProfile").attr("disabled", false);
                    $("#newPswProfile").attr("disabled", false);
                    $("#newPswRepeatProfile").attr("disabled", false);

                    $("#currentPswProfile").val("");
                    $("#newPswProfile").val("");
                    $("#newPswRepeatProfile").val("");

                    $("#changePswButton").attr("disabled", false);

                    $("#changePswButton").html("Update");
                }, 1000);

            },
            error: function (parameter) {
                bla = parameter.data.Message;
                alert(bla);
            }
        });
    }
}
