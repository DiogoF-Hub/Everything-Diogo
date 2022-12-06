function signup() {
    JSvalidation = 0;

    firstName = $("#firstName").val();
    lastName = $("#lastName").val();

    email = $("#email").val();

    password = $("#password").val();
    passwordRepeat = $("#passwordRepeat").val();


    if (!firstName) {
        $("#firstName").parent().children("div").html("Please Write something for First Name");
        JSvalidation++;
    } else {
        $("#firstName").parent().children("div").html("");
    }


    if (!lastName) {
        $("#lastName").parent().children("div").html("Please Write something for Last Name");
        JSvalidation++;
    } else {
        $("#lastName").parent().children("div").html("");
    }


    if (!email) {
        $("#email").parent().children("div").html("Please Write something for Email");
        JSvalidation++;
    } else {
        $("#email").parent().children("div").html("");
    }


    if (!password || !passwordRepeat) {

        if (!password) {
            $("#password").parent().children("div").html("Please Write something for Password");
            JSvalidation++;
        } else {
            $("#password").parent().children("div").html("");
        }


        if (!passwordRepeat) {
            $("#passwordRepeat").parent().children("div").html("Please Write something for Repeat Password");
            JSvalidation++;
        } else {
            $("#passwordRepeat").parent().children("div").html("");
        }


    } else {
        if ($.trim(password) !== $.trim(passwordRepeat)) {
            $("#passwordRepeat").parent().children("div").html("Please Write the same Password");
            $("#password").parent().children("div").html("");
            JSvalidation++;
        } else {
            $("#password").parent().children("div").html("");
            $("#passwordRepeat").parent().children("div").html("");
        }
    }





    if (JSvalidation == 0) {

    }
}