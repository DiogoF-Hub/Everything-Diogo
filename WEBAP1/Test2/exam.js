$(start);

arrResponse = {
    "1": "Successfully created the city",
    "2": "Cannot add duplicate city",
    "3": "Cannot add empty city"
}

function start() {
    getCitiesOptions();

    $("#AddCity").bind("click", function () {
        InputVal = $("#NewCity").val();
        $.ajax({
            url: "ServerApi.php",
            type: "POST",
            data: ({
                'saveCity': InputVal
            }),
            success: function (parameter) {
                response = $.parseJSON(parameter);

                $("#replyFromServer").html(arrResponse[response.id]);

                if (response.id == "1") {
                    getCitiesOptions();
                    $("#replyFromServer").attr("class", "success");
                } else {
                    $("#replyFromServer").attr("class", "fail");
                }
            }
        });
    });


    $("#DeleteCity").bind("click", function () {
        deleteCity = $("#CityList").val();

        $.ajax({
            url: "ServerApi.php",
            type: "POST",
            data: ({
                'deleteCity': deleteCity
            }),
            success: function (parameter) {
                getCitiesOptions();
            }
        });
    });
}


function getCitiesOptions() {
    $("#CityList").html("");

    $.ajax({
        url: "ServerApi.php",
        type: "POST",
        data: ({
            'GetOptions': 'GetOptions'
        }),
        success: function (parameter) {

            var parsedJson = $.parseJSON(parameter);

            for (var i = 0; i < parsedJson.length; i++) {
                let myOption = $("<option>");
                myOption.html(parsedJson[i]);
                myOption.val(parsedJson[i]);
                $("#CityList").append(myOption);
            }
        }
    });
}