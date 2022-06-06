<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../Styling/MyStylesEN.css?t<?= time(); ?>'>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src='../bootstrap/js/bootstrap.bundle.min.js'></script>
    <title>Document</title>
</head>

<body>

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




    <script src="../jquery/jquery-3.6.0.min.js"></script>
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
                    dayOption = $('#dayOption');
                    dayOption.removeAttr("disabled");
                    dayOption.removeAttr("selected");

                    dayOption.attr("selected", "selected");
                    dayOption.attr("disabled", "selected");

                    alert("Wrong day");
                }


            }
        }
    </script>
    <form class="container">
        <div class="row">
            <div class="col">
                <span class="form-group">
                    <select class="select2" id="day" name="dd"></select>
                </span>
            </div>

            <div class="col">
                <span class="form-group">
                    <select class="select2" id="month" name="mm" onchange="change_month(this)"></select>
                </span>
            </div>

            <div class="col">
                <span class="form-group">
                    <select class="select2" id="year" name="yyyy" onchange="change_year(this)"></select>
                </span>
            </div>
        </div>
    </form>

    <br><br>
    <script>
        function submitSettings() {
            document.getElementById('myform').submit()

            input1 = document.getElementById("input1").value;
            if (input1.length == 0) {
                alert("input1 is empty");
            }
        }
    </script>

    <form method="POST" id="myform">
        <div>myInput1 <input type="text" name="input1" id="input1"></div>
        <div>myInput2 <input type="text" name="input2"></div>
        <div>myInput3 <input type="text" name="input3"></div>
        <div>myInput4 <input type="text" name="input4"></div>
        <a href="javascript:{}" onclick="submitSettings();">Save Changes</a>
        <input type="hidden" name="myA" value="form">
    </form>

    <?php
    (int)$ThisYear = date("Y");
    print "<script>alert('" . $ThisYear . "');</script>";
    if (isset($_POST["myA"])) {
        print "nice";
        print "<script>alert('" . $_POST["input1"] . "');</script>";
        print "<script>alert('" . $_POST["input2"] . "');</script>";
        print "<script>alert('" . $_POST["input3"] . "');</script>";
        print "<script>alert('" . $_POST["input4"] . "');</script>";
    }
    ?>

</body>

</html>