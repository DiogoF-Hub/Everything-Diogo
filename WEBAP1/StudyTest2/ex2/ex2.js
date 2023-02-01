$(start);

arr = [];
arrSaved = [];

function start() {
    createBoard();
    createOptions();


    $("#saveBtn").bind("click", function () {
        $.ajax({
            url: "ex2.php",
            type: "POST",
            data: ({
                'saveArr': JSON.stringify(arr)
            }),
            success: function (parameter) {
                alert("Your game was saved");
                createOptions();
            }
        });
    });



    $("#TableSaves").bind("change", function () {
        saveGameId = $("#TableSaves").val();
        $.ajax({
            url: "ex2.php",
            type: "POST",
            data: ({
                'getSaveGame': saveGameId
            }),
            success: function (parameter) {
                arrSaved = $.parseJSON(parameter);
                createBoard(arrSaved);
            }
        });
    });
}


function createBoard() {
    $("#gameOfLifeTable").html("");

    rows = 10;
    cols = 10;
    BoxCounter = 1;

    for (let i = 1; i <= rows; i++) {

        let DivRows = $("<div>");

        for (let b = 1; b <= cols; b++) {
            let DivBox = $("<div>");


            if ($.inArray(BoxCounter, arrSaved) !== -1) {
                DivBox.attr("class", "box Selected");
            } else {
                DivBox.attr("class", "box notSelected");
            }


            DivBox.html(BoxCounter);

            DivBox.bind("click", function () {
                number = Number($(this).html());
                if ($(this).hasClass('notSelected')) {
                    $(this).removeClass('notSelected');
                    $(this).addClass('Selected');

                    arr.push(number);
                } else {
                    $(this).removeClass('Selected');
                    $(this).addClass('notSelected');

                    arr.splice($.inArray(number, arr), 1);
                }
            });

            DivRows.append(DivBox);
            BoxCounter++;
        }


        $("#gameOfLifeTable").append(DivRows);
    }
}


function createOptions() {
    $("#TableSaves").html("");

    myFirstOption = $("<option>")
    myFirstOption.attr("selected", true);
    myFirstOption.attr("disabled", true);
    myFirstOption.val("-1");
    myFirstOption.html("Select")
    $("#TableSaves").append(myFirstOption);

    $.ajax({
        url: "ex2.php",
        type: "POST",
        data: ({
            'GetOptions': 'GetOptions'
        }),
        success: function (parameter) {

            var parsedJson = $.parseJSON(parameter);

            for (var i = 0; i < parsedJson.length; i++) {
                let myOption = $("<option>");
                myOption.html(parsedJson[i].id);
                $("#TableSaves").append(myOption);
            }
        }
    });
}