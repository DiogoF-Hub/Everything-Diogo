$(start);

function start() {
    $(".deleteReservClass").bind("click", function () {

        if (confirm("Are you sure you want to delete this reservation?")) {

            bookingID = $(this).parent().children("input").val();

            myDiv = $(this).parent().parent().parent();

            $.ajax({
                url: "../PHP/CheckReservation.php", //ajax url
                type: "POST", //request type
                data: ({ //the data with the val
                    RemoveReserv: bookingID,
                }),
                success: function (parameter) { //If its good
                    bla = parameter.data.Message; //get the message

                    if (bla == true) {

                        if ($(myDiv).find('hr').length == 0) {
                            $("#allReservsDiv").find('hr').last().remove();
                        }

                        myDiv.remove();
                    } else {
                        location.reload();
                    }
                },
            });
        }
    });
}