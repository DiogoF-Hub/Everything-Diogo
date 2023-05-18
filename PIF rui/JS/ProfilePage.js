$(start);

// This will tell you if you haven't filled all of the fields with an alert and if you did fill them it will only execute.
function start() {
    $("#btnEdit").bind("click", function () {
        validationJS = 0;

        FirstName = $("#FirstName").val();
        Surname = $("#Surname").val();
        BadgeNum = $("#BadgeNum").val();


        if (!FirstName || !Surname || !BadgeNum) {
            alert("Please fill all fields!");
            validationJS++;
        }

        if (validationJS == 0) {
            $("#InfoDisplay").submit();
        }
    });
    // end

    // This will make the button work when you want to change your password and again it will show a message if you didn't fill your fields and if you did it will execute 
    $("#btnSavePSW").bind("click", function () {
        validationJS = 0;

        currentpassword = $("#currentpassword").val();
        Newpassword = $("#Newpassword").val();
        NewpasswordRepeat = $("#NewpasswordRepeat").val();


        if (!currentpassword || !Newpassword || !NewpasswordRepeat) {
            alert("Please fill all fields!");
            validationJS++;
        } else {
            if (Newpassword != NewpasswordRepeat) {
                alert("New Password is not the same as New Password Repeat!");
                validationJS++;
            }
        }

        if (validationJS == 0) {
            $("#changePSWForm").submit();
        }
    });
    // end
}

