$(start);

var toggle = true; //func toggle

RoomsInfo = [];

//hours arr for toggle
hoursArr = {
    "1": {
        startTime: "08:00",
        endTime: "09:00"
    },
    "2": {
        startTime: "09:00",
        endTime: "10:00"
    },
    "3": {
        startTime: "10:00",
        endTime: "11:00"
    },
    "4": {
        startTime: "11:00",
        endTime: "12:00"
    },
    "5": {
        startTime: "12:00",
        endTime: "13:00"
    },
    "6": {
        startTime: "13:00",
        endTime: "14:00"
    },
    "7": {
        startTime: "14:00",
        endTime: "15:00"
    },
    "8": {
        startTime: "15:00",
        endTime: "16:00"
    },
    "9": {
        startTime: "16:00",
        endTime: "17:00"
    }
}

function start() {

    //hide
    $("#extraInfo").hide();
    $("#resetBtn").parent().hide();

    //Enable bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    //enable flatpickr into the input type date
    flatpickr("#inputDate", {
        dateFormat: "d-m-Y",
        minDate: "today",
        disableMobile: "true",
        "disable": [
            function (date) {
                return (date.getDay() === 0 || date.getDay() === 6);  // disable weekends
            }
        ],
        "locale": {
            "firstDayOfWeek": 1 // set start day of week to Monday
        }
    });


    //put the options
    $.each(hoursArr, function (index, value) {
        let myoption2 = `<option value=${index}>${value.startTime}</option>`;
        $("#startTimeSelect").append(myoption2);
    });

    //input type date validation
    $("#inputDate").bind("input", function () {
        a = $(this).val();

        if (!a) {
            $(this).parent().children("div").eq(1).html("Please select a date");
        } else {
            $(this).parent().children("div").eq(1).html("");
        }
    });

    //start time select
    $("#startTimeSelect").bind("change", function () {

        let a = Number($(this).val());

        if (!a || a == "-1") {
            $("#startTimeSelect").parent().children("div").html("Please select an hour");
            $("#endTimeSelect").attr("disabled", true);
            $("#endTimeSelect").html("<option value='-1'>----</option>");
            return;
        } else {
            $("#startTimeSelect").parent().children("div").html("");
        }

        $("#endTimeSelect").attr("disabled", false);
        $("#endTimeSelect").html("");

        //choosing changes the end time select
        $.each(hoursArr, function (index, value) {
            if (Number(index) >= a) {
                let myoption3 = `<option value=${(index)}>${value.endTime}</option>`;
                $("#endTimeSelect").append(myoption3);
            }
        });
    });


    //use the same button to run 2 different func by toggling
    $("#SearchRooms").bind("click", function () {
        toggle ? RoomsShow() : Submit();
    });


    //room select validation and update desc and capacity
    $("#roomsSelect").bind("change", function () {
        a = Number($(this).val());
        let roominfo = RoomsInfo.filter(obj => {
            return obj.room_id === a
        })
        roominfo = roominfo[0]

        $("#tooltipDescription").attr('data-bs-original-title', roominfo.room_description);
        $("#capacityDiv").html("Room capacity: " + roominfo.room_capacity);
    });


    //reset func to normal
    $("#resetBtn").bind("click", function () {
        resetFunc();
    });

}


function resetFunc() {//reset func
    toggle = true;

    $("#extraInfo").slideUp("slow");

    $("#tooltipDescription").attr('data-bs-original-title', "Select a Room to see his description");
    $("#capacityDiv").html("Room capacity: ");

    $("#roomsSelect").parent().children("div").html("");
    $("#purpose").parent().children("div").html("");

    $("#resetBtn").parent().hide("slow");
    $("#roomsSelect").html('<option selected disabled value="-1">Select Room</option>');
    $("#purpose").val("");

    $("#roomsSelect").attr("disabled", false);
    $("#purpose").attr("disabled", false);

    $("#SearchRooms").html("Search");

    setTimeout(function () {
        $("#inputDate").val("");
        $("#startTimeSelect").val("-1");

        $("#endTimeSelect").html('<option value="-1">----</option>');

        $("#inputDate").attr("disabled", false);
        $("#startTimeSelect").attr("disabled", false);
        $("#endTimeSelect").attr("disabled", true);

        $("button").attr("disabled", false);
    }, 735);
}


function RoomsShow() { //show rooms available from date and time
    toggle = false;

    JSvalidation = 0;

    inputDate = $("#inputDate").val();

    startTimeVal = $("#startTimeSelect").val();
    endTimeVal = $("#endTimeSelect").val();

    //input type date validation
    if (!inputDate) {
        $("#inputDate").parent().children("div").eq(1).html("Please select a date");
        JSvalidation++;
    } else {
        $("#inputDate").parent().children("div").eq(1).html("");
    }

    //select start time validation
    if (!startTimeVal || !endTimeVal) {
        window.location.reload();
    } else {
        if (startTimeVal == "-1") {
            $("#startTimeSelect").parent().children("div").html("Please select an hour");
            JSvalidation++;
        } else {
            $("#startTimeSelect").parent().children("div").html("");
        }
    }


    if (JSvalidation == 0) {//if everything is fine
        if (endTimeVal >= startTimeVal) {
            $.ajax({ //ajax call
                url: "../PHP/CheckReservation.php",
                type: "POST",
                dataType: "json",
                data: ({
                    inputDate: inputDate,
                    startTimeVal: startTimeVal,
                    endTimeVal: endTimeVal
                }),
                beforeSend: function () {
                    //loading ex
                    $("#SearchRooms").attr("disabled", true);
                    $("#SearchRooms").html("");
                    $("#SearchRooms").append(buttonSpinner);

                    $("#inputDate").attr("disabled", true);
                    $("#startTimeSelect").attr("disabled", true);
                    $("#endTimeSelect").attr("disabled", true);
                },
                success: function (parameter) {
                    bla = parameter.data.Message;
                    if (bla == "1") {

                        RoomsJSON = parameter.data.Rooms;
                        RoomsInfo = RoomsJSON; //copy result to this array

                        $.each(RoomsJSON, function (index, value) { //put rooms into the select
                            let myoption4 = `<option value='${(value.room_id)}'>${(value.room_number)}</option>`;
                            $("#roomsSelect").append(myoption4);
                        });


                        setTimeout(function () {
                            $("#extraInfo").slideDown("slow");
                            $("#resetBtn").parent().show("slow");

                            $("#SearchRooms").attr("disabled", false);
                            $("#SearchRooms").html("Create");
                        }, 500);
                    } else {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function (parameter) {
                    bla = parameter.data.Message;
                    alert(bla);
                }
            });
        } else {
            window.location.reload();
        }
    }
}

function Submit() { //submit reser
    JSvalidation2 = 0;

    inputDate2 = $("#inputDate").val();

    startTimeVal2 = $("#startTimeSelect").val();
    endTimeVal2 = $("#endTimeSelect").val();

    roomsIDSelect = $("#roomsSelect").val();

    purpose = $("#purpose").val();

    //validation
    if (!inputDate2) {
        window.location.reload();
        return;
    }


    //validation
    if (!startTimeVal2 || !endTimeVal2) {
        window.location.reload();
    } else {
        if (startTimeVal2 == "-1") {
            window.location.reload();
            return;
        }

        if (endTimeVal2 < startTimeVal2) {
            window.location.reload();
            return;
        }
    }


    //validation
    if (!roomsIDSelect) {
        $("#roomsSelect").parent().children("div").html("Please select a room");
        JSvalidation2++;
    } else {
        if (isNumeric(roomsIDSelect)) {
            if (roomsIDSelect == "-1") {
                $("#roomsSelect").parent().children("div").html("Please select a room");
                JSvalidation2++;
            } else {
                $("#roomsSelect").parent().children("div").html("");
            }
        } else {
            window.location.reload();
            return;
        }
    }

    //validation
    if (!purpose) {
        $("#purpose").parent().children("div").html("Please write something for purpose");
        JSvalidation2++;
    } else {
        $("#purpose").parent().children("div").html("");
    }


    if (JSvalidation2 == 0) {
        $.ajax({
            url: "../PHP/CheckReservation.php",
            type: "POST",
            dataType: "json",
            data: ({
                inputDate2: inputDate2,
                startTimeVal2: startTimeVal2,
                endTimeVal2: endTimeVal2,
                roomsIDSelect: roomsIDSelect,
                purpose: purpose
            }),
            beforeSend: function () {
                //loading ex
                $("button").attr("disabled", true);
                $("#SearchRooms").html("");
                $("#SearchRooms").append(buttonSpinner);

                $("input").attr("disabled", true);
                $("#purpose").attr("disabled", true);
                $("select").attr("disabled", true);
            },
            success: function (parameter) {
                bla = parameter.data.Message;
                if (bla == "1") { //1 is good
                    setTimeout(function () {
                        alert("Reservation was created successfully");
                        resetFunc();
                    }, 600)
                } else { //anything else
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (parameter) {
                bla = parameter.data.Message;
                alert(bla);
            }
        });
    }
}
