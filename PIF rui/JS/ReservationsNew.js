$(start);


function start() {
    $('#inputDate').on('change', function () {
        var selectedDate = new Date($(this).val());
        var dayOfWeek = selectedDate.getDay();

        // 0 = Sunday, 6 = Saturday
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            alert('Weekend dates are disabled.');
            $(this).val('');
        }
    });


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


    $.each(hoursArr, function (index, value) {
        let myoption2 = `<option value=${index}>${value.startTime}</option>`;
        $("#start-time").append(myoption2);
    });


    $("#end-time").attr("disabled", true);

    $("#start-time").bind("change", function () {

        let a = Number($(this).val());

        $("#end-time").html("");

        //choosing changes the end time select
        $.each(hoursArr, function (index, value) {
            if (Number(index) >= a) {
                let myoption3 = `<option value=${(index)}>${value.endTime}</option>`;
                $("#end-time").append(myoption3);
            }
        });


        $("#end-time").attr("disabled", false);
    });



    $("#gobtn").bind("click", function () {

        startTime = $("#start-time").val();
        endTime = $("#end-time").val();

        dateSelected = $("#inputDate").val();


        if (startTime >= 1 && startTime <= 9 && endTime >= 1 && endTime <= 9) {

            // Check if the date is valid
            var date = new Date(dateSelected);
            if (isNaN(date.getTime())) {
                // Invalid date
                alert('Invalid date');
                $("#inputDate").val("");
                return; //stop running the rest
            }


            $.ajax({ //ajax call
                url: "../PHP/newReservation.php",
                type: "POST",
                dataType: "json",
                data: ({
                    dateSelected: dateSelected,
                    startTime: startTime,
                    endTime: endTime
                }),
                success: function (parameter) {
                    bla = parameter.data.Message;

                },
            });

        } else {
            alert("Please select all the options needed");
        }
    });
}