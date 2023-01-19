$(start); //This func will run only after the page fully loads

function start() {
    $(".buttonSave").bind("click", function () { //Here I bind every button with that class that when its clicked to run this
        userid = $(this).parent().children("input").val(); //This is will make the js know what I used Im trying to change, because is taking the val of an input that is sitting hidden close to the button where I print the user id into the val of that same input

        newgroup = $("#formUser" + userid).find("select").val(); //for every select I give it an id and I add the user id to it, and at this moment I know what user im trying to update so I will get what option what selected

        if ($.isNumeric(newgroup)) { //Here I check if the variable is numeric
            $.ajax({
                url: "../PHP/admin.php", //here is the ajax url
                type: "POST", //Here is the ajax type
                data: ({//The data names with the variables with theirs values (my names of the post and the name of the variables are the same)
                    userid: userid,
                    newgroup: newgroup
                }),
                beforeSend: function () {
                    //loading ex
                    $("button").attr("disabled", true); //This makes every button disabled
                    $("select").attr("disabled", true); //This makes every select disabled

                    $("#saveAdminBtn" + userid).html(""); //This clears the html of the button of the user that Im trying to update
                    $("#saveAdminBtn" + userid).append(buttonSpinner); //This will append the spinner inside the button (the spinner variable comes from the JS common code)
                },
                success: function (parameter) { //This will only run if it succeeded
                    bla = parameter.data.Message;
                    if (bla == "2") { //if the message inside the json is = to 2 then it run this
                        setTimeout(function () { //give it a 1s to run this
                            $("#selectAdmin" + userid + " option[value='" + userid + "']").attr("Selected", true); //this will make the option that the user selected being selected

                            $("button").attr("disabled", false); //this makes every button available again
                            $("select").attr("disabled", false); //this makes every select available again

                            $("#saveAdminBtn" + userid).html("Save"); //this makes the button that the user just edited = to save
                        }, 1000);
                    } else { //if its not = to 2, just reloads the page after 1s
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                },
            });
        }
    });
}