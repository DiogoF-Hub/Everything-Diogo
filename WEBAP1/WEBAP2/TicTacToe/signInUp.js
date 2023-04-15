$(start);

sign = 1;

function start() {

    $("#sectionTest").hide();
    $("#signUpInput").hide();

    $("#changeSign").bind("click", function () {
        if (sign == 1) {
            $("#signInInput").hide(350);
            $("#signUpInput").show(350);

            $("#SignButton").html("Sign up");
            $("#changeSign").html("Sign in");
            $("#changeSign").parent().children("p").html("Already registerd?");

            sign = 0;
        } else {
            $("#signUpInput").hide(350);
            $("#signInInput").show(350);

            $("#SignButton").html("Sign in");
            $("#changeSign").html("Sign up");
            $("#changeSign").parent().children("p").html("Dont have an account yet?");

            sign = 1;
        }

    });
}