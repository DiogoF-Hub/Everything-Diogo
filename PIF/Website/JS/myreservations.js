$(start);

function start() {
    $(".deleteReservClass").bind("click", function () {
        myDiv = $(this).parent().parent().parent();

        if ($(myDiv).find('hr').length == 0) {
            $("#allReservsDiv").find('hr').last().remove();
        }

        myDiv.remove();
    });
}