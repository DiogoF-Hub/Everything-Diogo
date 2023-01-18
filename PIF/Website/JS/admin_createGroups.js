$(start);

function start() {

    $("#groupName").bind("focusout", async function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").html("");
            return;
        } else {
            if (await groupNametaken(a) == false) {
                $(this).parent().children("div").html("This Group Name already exist");
            } else {
                $(this).parent().children("div").html("");
            }
        }

    });

    $("#open_door_any_timeSwitch").bind("change", function () {
        open_door_any_timeSwitch = $("#open_door_any_timeSwitch").is(':checked');
        open_door_when_its_availableSwitch = $("#open_door_when_its_availableSwitch").is(':checked');

        if (open_door_any_timeSwitch == true) {
            $('#open_door_when_its_availableSwitch').prop('checked', true);
            $('#open_door_when_its_availableSwitch').attr("disabled", true);
        } else {
            $('#open_door_when_its_availableSwitch').attr("disabled", false);
        }
    });

    $("#ScheduleSwitch").bind("change", function () {
        ScheduleSwitch = $("#ScheduleSwitch").is(':checked');
        view_scheduleSwitch = $("#view_scheduleSwitch").is(':checked');

        if (ScheduleSwitch == true) {
            $("#view_scheduleSwitch").prop('checked', true);
            $("#view_scheduleSwitch").attr("disabled", true);
        } else {
            $("#view_scheduleSwitch").attr("disabled", false);
        }
    });

    $("#createGroupBtn").bind("click", async function () {
        JSvalidation = 0;

        Schedule = 0;
        view_schedule = 0;
        view_sensitive_data = 0;
        open_door_any_time = 0;
        open_door_when_its_available = 0;

        groupName = $("#groupName").val();

        ScheduleSwitch = $("#ScheduleSwitch").is(':checked');
        view_scheduleSwitch = $("#view_scheduleSwitch").is(':checked');
        view_sensitive_dataSwitch = $("#view_sensitive_dataSwitch").is(':checked');
        open_door_any_timeSwitch = $("#open_door_any_timeSwitch").is(':checked');
        open_door_when_its_availableSwitch = $("#open_door_when_its_availableSwitch").is(':checked');

        if (!groupName) {
            $("#groupName").parent().children("div").html("Please write a Group Name");
            JSvalidation++;
        } else {
            if (await groupNametaken(groupName) == false) {
                $(this).parent().children("div").html("This Group Name already exist");
                JSvalidation++;
            } else {
                $(this).parent().children("div").html("");
            }
        }

        if (ScheduleSwitch == true) {
            Schedule = 1;
            view_schedule = 1;
        } else {
            if (view_scheduleSwitch == true) {
                view_schedule = 1;
            }
        }

        if (view_sensitive_dataSwitch == true) {
            view_sensitive_data = 1;
        }

        if (open_door_any_timeSwitch == true) {
            open_door_any_time = 1;
            open_door_when_its_available = 1;
        } else {
            if (open_door_when_its_availableSwitch == true) {
                open_door_when_its_available = 1;
            }
        }

        if (JSvalidation == 0) {
            $.ajax({
                url: "../PHP/admin.php",
                type: "POST",
                data: ({
                    groupName: groupName,
                    Schedule: Schedule,
                    view_schedule: view_schedule,
                    view_sensitive_data: view_sensitive_data,
                    open_door_any_time: open_door_any_time,
                    open_door_when_its_available: open_door_when_its_available
                }),
                beforeSend: function () {
                    //loading ex
                    $("#groupName").attr("disabled", true);

                    $("input").attr("disabled", false);

                    $("#createGroupBtn").html("");

                    $("#createGroupBtn").append(buttonSpinner);
                },
                success: function (parameter) {
                    bla = parameter.data.Message;
                    if (bla != "1") {
                        alert(bla);
                    }

                    setTimeout(function () {
                        $("#groupName").val("");
                        $("input[type='checkbox']").prop("checked", false);

                        $("input").attr("disabled", false);

                        $("#createGroupBtn").attr("disabled", false);
                        $("#createGroupBtn").html("Create");
                    }, 1000);

                },
                error: function (parameter) {
                    bla = parameter.data.Message;
                    alert(bla);
                }
            });
        }
    });
}




async function groupNametaken(a) {//this is async so just waits until the line 149 as finished that means, tun the whole test func
    let free = true; //flag for the return
    async function test(a) { //func inside a func bcs we need the return    // This one just goes on only after the whole ajax func as finished
        await $.ajax({
            url: "../PHP/groupNameTaken.php",
            type: "POST",
            data: ({
                groupNametaken: a,
            }),
            success: function (parameter) {
                bla = parameter.data.Message;

                if (bla == "1") {
                    free = false;
                }

            },
        });
    }
    await test(a);

    return free;
}