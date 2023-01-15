$(start);

function start() {
    $(".buttonSave").bind("click", function () {
        userid = $(this).parent().children("input").val();

        newgroup = $("#formUser" + userid).find("select").val();

        if ($.isNumeric(newgroup)) {
            $.ajax({
                url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/admin.php",
                type: "POST",
                data: ({
                    userid: userid,
                    newgroup: newgroup
                }),
                beforeSend: function () {
                    //loading ex
                    $(".buttonSave").attr("disabled", true);
                    $("select").attr("disabled", true);

                    $("#saveAdminBtn" + userid).html("");
                    $("#saveAdminBtn" + userid).append(buttonSpinner);
                },
                success: function (parameter) {
                    bla = parameter.data.Message;
                    if (bla == "2") {
                        setTimeout(function () {
                            $("#selectAdmin" + userid + " option[value='" + userid + "']").attr("Selected", true);

                            $(".buttonSave").attr("disabled", false);
                            $("select").attr("disabled", false);

                            $("#saveAdminBtn" + userid).html("Save");
                        }, 1000);
                    } else {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                },
            });
        }
    });
}