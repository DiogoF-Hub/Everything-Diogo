$(Start); //This runs when the pages fully loads

//Here I define the variables empty that then I edit them from html script tag
sessionEmail = "";
sessionBadge = "";

function Start() {

    $("#buttonPic").bind("click", function () {
        myInputFile = $("#buttonPic").parent().children("input").click();
    });


    $("#ProfileImgInput").on("change", function (event) {
        var output = $("#ProfileImg");
        var file = event.target.files[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith("image/") || !(/\.(jpe?g|png)$/i).test(file.name)) {
            return;
        }

        output.attr("src", URL.createObjectURL(file));
        output.on("load", function () {
            URL.revokeObjectURL(output.attr("src"));
        });

        var formData = new FormData();
        formData.append("image", file);

        $.ajax({
            url: "../PHP/EditProfile.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (parameter) {
                bla = parameter.data.Message;
            }
        });
    });



    $("#emailProfile").bind("focusout", async function () { //Here I bind the input emailProfile that when you focus out run this
        a = $(this).val(); //With this I get the val

        if (!a) { //If its empty
            $(this).parent().children("div").html("Please write an email"); //If its empty I write an error inside the div
            return; //return here works to just skip everything else
        }

        if (a != sessionEmail) { //Only run this if a is not = to the session email so I don't need to run any checks
            if (checkEmail($.trim(a)) == false) { //Here I check if its an valid email
                $(this).parent().children("div").html("Please write a valid Email"); //If not I write an error
            } else {
                if (await emailtaken(a) == false) { //here I check if the email is already taken, I use await to really wait until the func run and only then check its true or false
                    $(this).parent().children("div").html("This email is already taken"); //If its taken, I write this error
                } else {
                    $(this).parent().children("div").html(""); //Here I clear the error div
                }

            }
        }
    });


    $("#firstNameProfile, #lastNameProfile").bind("focusout", function () { //Here I bind the input firstNameProfile and lastNameProfile that when you focus out run this
        a = $(this).val(); //With this I get the val

        if (!a) { //If its empty
            $(this).parent().children("div").html("Please write a name"); //If its empty I write an error inside the div
            return;//return here works to just skip everything else
        }

        if (checkNames(a) == false) { //Here I check if its an valid name
            $(this).parent().children("div").html("Please write a name with letters"); //If not I write an error
        } else {
            $(this).parent().children("div").html(""); //Here I clear the error div
        }

    });


    $("#currentPswProfile, #newPswProfile").bind("focusout", function () { //Here I bind the input currentPswProfile and newPswProfile that when you focus out run this
        a = $(this).val(); //With this I get the val

        if (!a) { //If its empty
            $(this).parent().children("div").html(""); //Here I clear the error div
            return; //return here works to just skip everything else
        }

        if (a.length < 8) { //If it has less than 8 characters
            $(this).parent().children("div").html("The password must contain a minimum of 8 characters"); //Then I write the error
        } else {
            $(this).parent().children("div").html(""); //Here I clear the error div
        }
    });

    $("#newPswRepeatProfile").bind("focusout", function () { //Here I bind the input newPswRepeatProfile that when you focus out run this
        a = $(this).val(); //With this I get the val

        if (!a) { //If its empty
            $(this).parent().children("div").html(""); //Here I clear the error div
            return; //return here works to just skip everything else
        }

        if (a.length < 8) { //If it has less than 8 characters
            $(this).parent().children("div").html("The password must contain a minimum of 8 characters"); //Then I write the error
        } else {
            b = $("#newPswProfile").val(); //With this I get the val of the other input

            if ($.trim(a) !== $.trim(b)) { //Then I trim to remove any white spaces for both then I check if they are the same
                $(this).parent().children("div").html("The passwords don't match"); //if not, then I write the error
            } else {
                $(this).parent().children("div").html(""); //Here I clear the error div
            }
        }
    });

    //Here I bind the 2 buttons to run 2 different functions
    $("#saveProfile").bind("click", saveProfile);
    $("#changePswButton").bind("click", changePsw);
}


//save profile func
async function saveProfile() {
    JSvalidation = 0;

    //get the input val
    firstNameProfile = $("#firstNameProfile").val();
    lastNameProfile = $("#lastNameProfile").val();
    emailProfile = $("#emailProfile").val();
    BadgeNumber = $("#BadgeNumber").val();

    //first name validation
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

    //last name validation
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

    //email validation
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

    //if its session badge
    if (sessionBadge == BadgeNumber) {
        BadgeNumber = -1;
    }

    //If everything is fine
    if (JSvalidation == 0) {
        $.ajax({
            url: "../PHP/EditProfile.php", //ajax url
            type: "POST", //request type
            data: ({ //the data with the val
                firstNameProfile: firstNameProfile,
                lastNameProfile: lastNameProfile,
                emailProfile: emailProfile,
                BadgeNumber: BadgeNumber
            }),
            beforeSend: function () { //before sending
                //loading ex
                //disable the fields
                $("#firstNameProfile").attr("disabled", true);
                $("#lastNameProfile").attr("disabled", true);
                $("#emailProfile").attr("disabled", true);
                $("#BadgeNumber").attr("disabled", true);
                $("#saveProfile").attr("disabled", true);

                //Empty html
                $("#saveProfile").html("");

                //append spinner loading
                $("#saveProfile").append(buttonSpinner);
            },
            success: function (parameter) { //If its good
                bla = parameter.data.Message; //get the message
                if (bla != "1") {//ifs its not 1 I alert message
                    alert(bla);
                }

                setTimeout(function () {//put fields back and save
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
            error: function (parameter) {//if something bad happens
                bla = parameter.data.Message;
                alert(bla);
            }
        });
    }
}




function changePsw() {//func to change the psw
    JSvalidation = 0;

    //get the input val
    currentPsw = $("#currentPswProfile").val();
    newPsw = $("#newPswProfile").val();
    newPswRepeat = $("#newPswRepeatProfile").val();

    //current psw validation
    if (!currentPsw) {
        $("#currentPswProfile").parent().children("div").html("Please write something for Password");
        JSvalidation++;
    } else {
        if (currentPsw.length < 8) {
            $("#currentPswProfile").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
        }
    }

    //new psw validation
    if (!newPsw) {
        $("#newPswProfile").parent().children("div").html("Please write something for Password");
        JSvalidation++;
    } else {
        if (newPsw.length < 8) {
            $("#newPswProfile").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
        }
    }

    //new psw repeat psw validation
    if (!newPswRepeat) {
        $("#newPswRepeatProfile").parent().children("div").html("Please write something for Password");
        JSvalidation++;
    } else {
        if (newPswRepeat.length < 8) {
            $("#newPswRepeatProfile").parent().children("div").html("The password must contain a minimum of 8 characters");
            JSvalidation++;
        }
    }

    //check if its not the same
    if (newPsw !== newPswRepeat) {
        $("#newPswRepeatProfile").parent().children("div").html("The passwords dont match");
        JSvalidation++;
    }

    if (JSvalidation == 0) {
        $.ajax({
            url: "../PHP/EditProfile.php", //ajax url
            type: "POST", //request type
            data: ({//data with val
                currentPsw: currentPsw,
                newPsw: newPsw,
                newPswRepeat: newPswRepeat
            }),
            beforeSend: function () {
                //loading ex
                //disable fields
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
                setTimeout(function () { //put everything back
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
