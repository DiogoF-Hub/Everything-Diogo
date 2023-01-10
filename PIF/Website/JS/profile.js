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

    $("#PhoneNumberProfile").bind("focusout", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        }

        if (checkPhoneNumber(a) == false) {
            $(this).parent().children("div").html("Please write a valid phone number with country code (00 or +) and no spaces");
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
    PhoneNumberProfile = $("#PhoneNumberProfile").val();
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


    // if (!emailProfile) {
    //     $("#emailProfile").parent().children("div").html("Please Write something for Email");
    //     JSvalidation++;
    // } else {

    //     if (checkEmail(emailProfile) == false) {
    //         $("#emailProfile").parent().children("div").html("Please write a valid Email");
    //         JSvalidation++;
    //     } else {
    //         if (emailProfile != sessionEmail && await emailtaken(emailProfile) == false) {
    //             $("#emailProfile").parent().children("div").html("This email is already taken");
    //             JSvalidation++;
    //         } else {
    //             $("#emailProfile").parent().children("div").html("");
    //         }
    //     }

    // }


    if (PhoneNumberProfile) {
        if (checkPhoneNumber(PhoneNumberProfile) == false) {
            $("#PhoneNumberProfile").parent().children("div").html("Please write a valid phone number with country code (00 or +) and no spaces");
            JSvalidation++;
        } else {
            $("#PhoneNumberProfile").parent().children("div").html("");
        }
    } else {
        PhoneNumberProfile = -1;
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
                // emailProfile: emailProfile,
                PhoneNumberProfile: PhoneNumberProfile,
                BadgeNumber: BadgeNumber
            }),
            beforeSend: function () {
                //loading ex
            },
            success: function (parameter) {
                bla = parameter.data.Message;
                if (bla != "1") {
                    alert(bla);
                }
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
