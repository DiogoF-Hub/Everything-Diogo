$(start);

function start() {

    $("#Login").click(function () { // When the "Login" button is clicked
        $("#NextActions").html("");
        var user = $("#User").val(); // Get the user's name from the input field with id "User"

        if (user !== "") {
            $.ajax({ // Send an AJAX request to the server-side script with the user's name as a parameter
                url: "ServerSide.php",
                type: "GET", //request type
                data: ({ //the data with the val
                    User: user,
                }),
                success: function (result) { // If the AJAX request is successful
                    $("#AmountInAccount").html(result);// Display the balance

                    // Update the HTML of the element with id "NextActions" with input fields and buttons for deposit and withdrawal
                    //Create all the elements
                    MyInput = $("<input>");
                    MyInput.attr("type", "number");
                    MyInput.attr("id", "AmountInput");

                    MyBR = $("<br>");

                    MyButtonDeposit = $("<button>");
                    MyButtonDeposit.attr("id", "DepositButton");
                    MyButtonDeposit.html("Deposit");

                    MyButtonWithdraw = $("<button>");
                    MyButtonWithdraw.attr("id", "WithdrawButton");
                    MyButtonWithdraw.html("Withdraw");

                    //Append in order all the elements created
                    $("#NextActions").append(MyInput);
                    $("#NextActions").append(MyBR);
                    $("#NextActions").append(MyButtonDeposit);
                    $("#NextActions").append(MyButtonWithdraw);

                    $("#ResultOperation").html("");
                }
            });
        }

    });

    // To deposit
    $("#NextActions").on("click", "#DepositButton", function () {
        var amount = $("#AmountInput").val(); //Get the information from the newly created button
        var user = $("#User").val(); //Read the current user

        if (amount !== "" && user !== "") { //If the user wrote something on the input, only then do the ajax request
            $.ajax({
                url: "ServerSide.php",
                type: "GET", //request type
                data: ({ //the data with the val
                    depositAmount: amount,
                    User: user,
                }),
                success: function (result) {
                    $("#ResultOperation").html(result);
                    // Reload the account details after a successful deposit
                    reloadAccountDetails(user);
                }
            });
        }
    });

    // To withdraw
    $("#NextActions").on("click", "#WithdrawButton", function () {
        var amount = $("#AmountInput").val();
        var user = $("#User").val();

        if (amount !== "" && user !== "") {//If the user wrote something on the input, only then do the ajax request
            $.ajax({
                //"?withdrawAmount" is used in PHP
                url: "ServerSide.php",
                type: "GET", //request type
                data: ({ //the data with the val
                    withdrawAmount: amount,
                    User: user,
                }),
                success: function (result) {
                    $("#ResultOperation").html(result);
                    // Reload the account details after a successful withdrawal
                    reloadAccountDetails(user);
                }
            });
        }
    });

    // Function to reload the account details
    function reloadAccountDetails(user) {
        $("#AmountInAccount").load("ServerSide.php?User=" + user);
    }
};
