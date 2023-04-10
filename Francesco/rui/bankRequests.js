$(start);

function start() {
    $("#Login").bind("click", function () {
        $("#ResultOperation").html("");
        user = $("#User").val();

        if (user !== "") {
            $("#NextActions").html("");
            $.ajax({
                url: "Server.php",
                type: "GET",
                data: ({
                    userLogin: user,
                }),
                success: function (parameter) {

                    parameter = $.parseJSON(parameter);

                    UserFound = parameter.Message;


                    if (UserFound == "User found") {
                        $("#AmountInAccount").html(parameter.Balance);

                        InputElement = $("<input>");
                        InputElement.attr("type", "number");
                        InputElement.attr("id", "amount");

                        br = $("<br>");

                        DepositButton = $("<button>");
                        DepositButton.attr("id", "Deposit");
                        DepositButton.attr("class", "Actions")
                        DepositButton.html("Deposit");

                        WithdrawButton = $("<button>");
                        WithdrawButton.attr("id", "Withdraw");
                        WithdrawButton.attr("class", "Actions")
                        WithdrawButton.html("Withdraw");

                        $("#NextActions").append(InputElement);
                        $("#NextActions").append(br);
                        $("#NextActions").append(DepositButton);
                        $("#NextActions").append(WithdrawButton);

                    } else {
                        $("#ResultOperation").html("Unknown user");
                    }

                },
            });
        }

    });



    $("#NextActions").on("click", ".Actions", function () {
        user = $("#User").val();
        action = $(this).attr('id');
        amount = $("#amount").val();

        if (user !== "" && amount !== "") {
            $.ajax({
                url: "Server.php",
                type: "GET",
                data: ({
                    user: user,
                    action: action,
                    amount: amount,
                }),
                success: function (parameter) {
                    parameter = $.parseJSON(parameter);
                    Message = parameter.Message;

                    $("#ResultOperation").html(Message);
                    $("#AmountInAccount").html(parameter.Balance);
                },
            });
        }
    });
}