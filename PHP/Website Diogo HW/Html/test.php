<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function alert2() {
            DateOfBirth = document.getElementById("DateOfBirth").value;
            alert(DateOfBirth);
        }
    </script>
    <script></script>
</head>

<body>
    <input id="DateOfBirth" class="form-control" type="date" value="">
    <button onclick="alert2();">go</button>

    <?php
    //echo "<script>alert('" . date("d-m-Y") . "');</script>";

    if (isset($_POST["mybutton"])) {
        $alert = "";

        if (!empty($_POST["1"])) {
            $alert = $alert . " 1,";
        }

        if (!empty($_POST["2"])) {
            $alert = $alert . " 2,";
        }

        if (!empty($_POST["3"])) {
            $alert = $alert . " 3,";
        }

        if (!empty($_POST["4"])) {
            $alert = $alert . " 4,";
        }

        echo "<script>alert('You wrote somethin on " . $alert . "');</script>";
    }
    ?>

    <br><br>

    <style>
        .container {
            padding: 15px;
        }

        SELECT {
            padding: 5px;
        }

        input.date {
            width: 50px;
            padding: 5px;
        }
    </style>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var Days = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // index => month [0-11]
        $(document).ready(function() {
            var option = '<option id="dayOption" selected disabled value="day">Day</option>';
            var selectedDay = "day";
            for (var i = 1; i <= Days[0]; i++) { //add option days
                option += '<option value="' + i + '">' + i + '</option>';
            }
            $('#day').append(option);
            $('#day').val(selectedDay);


            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            var option = '<option selected disabled value="month">Month</option>';
            var selectedMon = "month";
            for (var i = 1; i <= 12; i++) {
                option += '<option value="' + i + '">' + months[i - 1] + '</option>';
            }
            $('#month').append(option);
            $('#month').val(selectedMon);

            var d = new Date();
            var option = '<option selected disabled value="year">Year</option>';
            selectedYear = "year";
            for (var i = d.getFullYear(); i >= 1910; i--) { // years start i
                option += '<option value="' + i + '">' + i + '</option>';
            }
            $('#year').append(option);
            $('#year').val(selectedYear);
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
            var option = '<option id="dayOption" selected disabled value="day">Day</option>';
            var month = parseInt($(select).val()) - 1;
            for (var i = 1; i <= Days[month]; i++) { //add option days
                if (val == i) {
                    option += '<option selected value="' + i + '">' + i + '</option>';
                } else {
                    option += '<option value="' + i + '">' + i + '</option>';
                }

            }
            $(day).append(option);
            if (val > Days[month]) {
                dayOption = $('#dayOption');
                dayOption.removeAttr("disabled", false);
                dayOption.removeAttr("selected", false);

                dayOption.attr("selected", true);
                dayOption.attr("disabled", true);

                day.get(0).setCustomValidity("Wrong day");
                day.get(0).reportValidity();
            } else {
                day.get(0).setCustomValidity("");
                day.get(0).reportValidity();
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
                var option = '<option id="dayOption" selected disabled value="day">Day</option>';
                for (var i = 1; i <= Days[1]; i++) { //add option days
                    if (val == i) {
                        option += '<option selected value="' + i + '">' + i + '</option>';
                    } else {
                        option += '<option value="' + i + '">' + i + '</option>';
                    }
                }
                $(day2).append(option);

                if (val > Days[1]) {
                    day2.get(0).setCustomValidity("Wrong day");
                    day2.get(0).reportValidity();

                    dayOption = $('#dayOption');
                    dayOption.removeAttr("disabled", false);
                    dayOption.removeAttr("selected", false);

                    dayOption.attr("selected", true);
                    dayOption.attr("disabled", true);

                } else {
                    day2.get(0).setCustomValidity("");
                    day2.get(0).reportValidity();
                }


            }
        }
    </script>

    <form class="container">
        <SELECT id="day" name="dd"></SELECT>
        <SELECT id="month" name="mm" onchange="change_month(this)"></SELECT>
        <SELECT id="year" name="yyyy" onchange="change_year(this)"></SELECT>
    </form>

    <br><br>

    <script>
        function testselectReport() {
            testselect = document.getElementById("testselect");

            if (testselect.value == "3") {
                testselect.setCustomValidity("Wrong awnser");
                testselect.reportValidity();
            } else {
                testselect.setCustomValidity("");
            }
        }
    </script>
    <select name="" id="testselect" onchange="testselectReport();">
        <option selected disabled value="-1">Choose</option>
        <option value="1">good awnser</option>
        <option value="2">good awnser</option>
        <option value="3">wrong</option>
    </select>
</body>

</html>