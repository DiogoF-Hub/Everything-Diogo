//date of birth selects
var Days = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // index => month [0-11]
$(document).ready(function () {
    var selectedDay = "day";
    for (var i = 1; i <= Days[0]; i++) { //add option days
        if (selectedDayN == i) {
            optionDay += '<option selected value="' + i + '">' + i + '</option>';
        } else {
            optionDay += '<option value="' + i + '">' + i + '</option>';
        }

    }
    $('#day').append(optionDay);
    if (selectedDayN == -1) {
        $('#day').val(selectedDay);
    }


    var selectedMon = "month";
    for (var i = 1; i <= 12; i++) {
        if (selectedMonthN == i) {
            optionMonth += '<option selected value="' + i + '">' + months[i - 1] + '</option>';
        } else {
            optionMonth += '<option value="' + i + '">' + months[i - 1] + '</option>';
        }

    }
    $('#month').append(optionMonth);
    if (selectedMonthN == -1) {
        $('#month').val(selectedMon);
    }


    var d = new Date();

    selectedYear = "year";
    for (var i = d.getFullYear(); i >= 1910; i--) { // years start i
        if (selectedYearN == i) {
            optionYear += '<option selected value="' + i + '">' + i + '</option>';
        } else {
            optionYear += '<option value="' + i + '">' + i + '</option>';
        }

    }
    $('#year').append(optionYear);
    if (selectedYearN == -1) {
        $('#year').val(selectedYear);
    }

});

function isLeapYear(year) {
    if (year == "year") {
        return true;
    } else {
        year = parseInt(year);
        if (year % 4 != 0) {
            return false;
        } else if (year % 400 == 0) {
            return true;
        } else if (year % 100 == 0) {
            return false;
        } else {
            return true;
        }
    }

}


function change_month(select) {
    var day = $('#day');
    var val = $(day).val();
    $(day).empty();
    var month = parseInt($(select).val()) - 1;
    for (var i = 1; i <= Days[month]; i++) { //add option days
        if (val == i) {
            optionDay2 += '<option selected value="' + i + '">' + i + '</option>';
        } else {
            optionDay2 += '<option value="' + i + '">' + i + '</option>';
        }

    }
    $(day).append(optionDay2);
    if (val > Days[month]) {
        dayOption = $('#dayOption');
        dayOption.removeAttr("disabled");
        dayOption.removeAttr("selected");

        dayOption.attr("selected", "selected");
        dayOption.attr("disabled", "selected");

        alert("Wrong day");
    }
}


function change_year(select) {
    if (isLeapYear($(select).val())) {
        Days[1] = 29;
    } else {
        Days[1] = 28;
    }


    month = $("#month").val();
    if (month == 2) {
        var day2 = $('#day');
        var val = $(day).val();
        $(day2).empty();
        for (var i = 1; i <= Days[1]; i++) { //add option days
            if (val == i) {
                optionYear2 += '<option selected value="' + i + '">' + i + '</option>';
            } else {
                optionYear2 += '<option value="' + i + '">' + i + '</option>';
            }
        }
        $(day2).append(optionYear2);

        if (val > Days[1]) {
            dayOption = $('#dayOption');
            dayOption.removeAttr("disabled");
            dayOption.removeAttr("selected");

            dayOption.attr("selected", "selected");
            dayOption.attr("disabled", "selected");

            alert("Wrong day");
        }


    }
}