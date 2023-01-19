$(start); //This func will run only after the page fully loads

function start() {

    $("#groupName").bind("focusout", async function () { //Here I bind the input group_name that when you focus out run this
        a = $(this).val();//With this I get the val

        if (!a) { //If its empty
            $(this).parent().children("div").html(""); //Clear the error div
            return; //return here works to just skip everything else
        } else {//if a is = to something
            if (await groupNametaken(a) == false) {//here I check if the group name is already taken, I use await to really wait until the func run and only then check its true or false
                $(this).parent().children("div").html("This Group Name already exist");//Here I write the error into the div
            } else {
                $(this).parent().children("div").html("");//Here I clear the error div
            }
        }
    });

    $("#open_door_any_timeSwitch").bind("change", function () { //Here I bind the input type checkbox that runs this func when its being checked
        //Here I get the true or false if the input is checked or not
        open_door_any_timeSwitch = $("#open_door_any_timeSwitch").is(':checked');

        if (open_door_any_timeSwitch == true) {//If this one is true I make the other input checked and disabled
            $('#open_door_when_its_availableSwitch').prop('checked', true);
            $('#open_door_when_its_availableSwitch').attr("disabled", true);
        } else {//if not I just remove the disable attribute from the input
            $('#open_door_when_its_availableSwitch').attr("disabled", false);
        }
    });

    $("#ScheduleSwitch").bind("change", function () { //Here I bind the input type checkbox that runs this func when its being checked
        //Here I get the true or false if the input is checked or not
        ScheduleSwitch = $("#ScheduleSwitch").is(':checked');

        if (ScheduleSwitch == true) {//If this one is true I make the other input checked and disabled
            $("#view_scheduleSwitch").prop('checked', true);
            $("#view_scheduleSwitch").attr("disabled", true);
        } else {//if not I just remove the disable attribute from the input
            $("#view_scheduleSwitch").attr("disabled", false);
        }
    });

    $("#createGroupBtn").bind("click", async function () { //This will run every time the user clicks on create group button
        JSvalidation = 0; //I define this variable = to 0, so then I use this to check if everything is all right to submit

        //Here I define all of this variables = 0, so then I can use them for the POST
        Schedule = 0;
        view_schedule = 0;
        view_sensitive_data = 0;
        open_door_any_time = 0;
        open_door_when_its_available = 0;

        //Here I take the input val
        groupName = $("#groupName").val();

        //Here I take the input val, if they are checked or not (true, false)
        ScheduleSwitch = $("#ScheduleSwitch").is(':checked');
        view_scheduleSwitch = $("#view_scheduleSwitch").is(':checked');
        view_sensitive_dataSwitch = $("#view_sensitive_dataSwitch").is(':checked');
        open_door_any_timeSwitch = $("#open_door_any_timeSwitch").is(':checked');
        open_door_when_its_availableSwitch = $("#open_door_when_its_availableSwitch").is(':checked');

        if (!groupName) {//If group name is empty
            $("#groupName").parent().children("div").html("Please write a Group Name");//I write the error
            JSvalidation++;//I increase the variable + 1
        } else {//if there is something written
            if (await groupNametaken(groupName) == false) {//here I check if the group name is already taken, I use await to really wait until the func run and only then check its true or false
                $(this).parent().children("div").html("This Group Name already exist");//I write the error
                JSvalidation++;//I increase the variable + 1
            } else {
                $(this).parent().children("div").html("");//Here I clear the error div
            }
        }

        if (ScheduleSwitch == true) { //if this is true i I define the variables = 1 (I don't need to write == true, but it makes easier to understand)
            Schedule = 1;             //If the user can schedule, the user can view it too so I force it like this
            view_schedule = 1;
        } else {//if its false
            if (view_scheduleSwitch == true) {//and if the other one its false only then I check this one and change to 1 if its true
                view_schedule = 1;            //And there is the possibility that the user can view the schedule but schedule
            }
        }

        if (view_sensitive_dataSwitch == true) { //if this is true i I define the variables = 1 (I don't need to write == true, but it makes easier to understand)
            view_sensitive_data = 1;
        }

        if (open_door_any_timeSwitch == true) {//if this is true i I define the variables = 1 (I don't need to write == true, but it makes easier to understand)
            open_door_any_time = 1;            //If the user can open the door at any time, the user can open the door when its available too so I force it like this
            open_door_when_its_available = 1;
        } else {
            if (open_door_when_its_availableSwitch == true) {//and if the other one its false only then I check this one and change to 1 if its true
                open_door_when_its_available = 1;           //And there is the possibility that the user can view the schedule but schedule
            }
        }

        if (JSvalidation == 0) { //If the variable is = 0 the I start with the ajax
            $.ajax({
                url: "../PHP/admin.php", //here I define the url of the file to send the POST
                type: "POST", //the type of the request
                data: ({//the data names with the variables with theirs values (my names of the post and the name of the variables are the same)
                    groupName: groupName,
                    Schedule: Schedule,
                    view_schedule: view_schedule,
                    view_sensitive_data: view_sensitive_data,
                    open_door_any_time: open_door_any_time,
                    open_door_when_its_available: open_door_when_its_available
                }),
                beforeSend: function () { //this will run before sending
                    //loading ex

                    $("input").attr("disabled", true); //This will make all the inputs disabled

                    $("#createGroupBtn").html(""); //This clears the html inside the button

                    $("#createGroupBtn").attr("disabled", true); //Here I disable the button

                    $("#createGroupBtn").append(buttonSpinner); //this will append the spinner inside the button (the spinner variable comes from the JS common code)
                },
                success: function (parameter) {//this will only run if it succeeded
                    bla = parameter.data.Message; //Here I get the message inside the json
                    if (bla != "1") { //if its not 1 alert the message
                        alert(bla); //I did this to only alert something when its not the users fault and not when he tries to inspect and change the code
                    }

                    setTimeout(function () {//I give it 1s to run this
                        $("#groupName").val(""); //I clear the input val
                        $("input[type='checkbox']").prop("checked", false); //I uncheck every input checkbox

                        $("input").attr("disabled", false); //I make every input available again

                        $("#createGroupBtn").attr("disabled", false); //I make the button available again
                        $("#createGroupBtn").html("Create"); //Here I write "Create" inside the button
                        //Basically with this timeout, I make everything as it was before the user clicked on the button
                    }, 1000);

                },
                error: function (parameter) { //If there is an error
                    bla = parameter.data.Message;
                    alert(bla); //Alert the message inside the json
                }
            });
        }
    });
}




async function groupNametaken(a) {//this is async func, so basically make the ability for me to use await
    let free = true; //flag for the return
    async function test(a) { //func inside a func bcs we need the return    // This one just goes on only after the whole ajax func as finished
        await $.ajax({
            url: "../PHP/groupNameTaken.php", //here is the url for the ajax request
            type: "POST", //ajax type
            data: ({
                groupNametaken: a, //the name of the post and the variable with the val
            }),
            success: function (parameter) { //this will only run if it succeeded
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