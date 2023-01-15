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

    $("#createGroupBtn").bind("click", async function () {
        JSvalidation = 0;

        groupName = $("#groupName").val();

        ScheduleSwitch = $("#ScheduleSwitch").is(':checked');
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

        if (JSvalidation == 0) {
            $.ajax({
                url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/admin.php",
                type: "POST",
                data: ({
                    groupName: groupName,
                    ScheduleSwitch: ScheduleSwitch,
                    view_sensitive_dataSwitch: view_sensitive_dataSwitch,
                    open_door_any_timeSwitch: open_door_any_timeSwitch,
                    open_door_when_its_availableSwitch: open_door_when_its_availableSwitch
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
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/groupNameTaken.php",
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