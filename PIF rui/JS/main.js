$(start);
/*Login form effect*/
signin = true;

// This is the animation to show and hide the sign in and sign up and to make the buttons work
function start() {
    mybutton = $("<button>");
    mybutton.attr("class", "btn btn-link text-primary fw-bold");
    mybutton.attr("id", "btnchange");
    mybutton.html("Sign Up");
    $("#pchange").append(mybutton);


    $("#signUpForm").hide();

    $("#pchange").on("click", "#btnchange", function () {

        if (signin == true) {
            $("#signInForm").hide(400);
            $("#signUpForm").show(400);

            $("#pchange").html("Already have an account?")
            mybutton.html("Sign In");
            $("#pchange").append(mybutton);


            signin = false;
        } else {
            $("#signUpForm").hide(400);
            $("#signInForm").show(400);

            $("#pchange").html("Don't have an account?")
            mybutton.html("Sign Up");
            $("#pchange").append(mybutton);

            signin = true;
        }

    });
    // end


    $("#signUpbtn").bind("click", function () {
        validationJS = 0;

        /*SignUp input values without white spaces(removes sapces between words)*/
        FirstName = $("#FirstName").val();
        LastName = $("#LastName").val();
        email = $("#email").val();
        password = $("#password").val();
        RepeatPassword = $("#RepeatPassword").val();
        BadgeNum = $("#BadgeNum").val();
        /*End*/

        /* Make sure all fields are filled, if not alerts by saying to fill all fields */
        if (!FirstName || !LastName || !email || !password || !RepeatPassword || !BadgeNum) {
            alert("Please fill all fields!");
            validationJS++;
        }


        if (password !== RepeatPassword) {
            alert("Passwords do not match!");
            validationJS++;
        }


        if (validationJS == 0) {
            $("#signUpForm").submit();
        }
    });


    $("#signInbtn").bind("click", function () {
        validationJS = 0;

        /*SignUp input values without white spaces(removes sapces between words)*/
        emailin = $("#emailin").val();
        passwordin = $("#passwordin").val();
        /*End*/

        /* Make sure all fields are filled, if not alerts by saying to fill all fields */
        if (!emailin || !passwordin) {
            alert("Please fill all fields!");
            validationJS++;
        }


        if (validationJS == 0) {
            $("#signInForm").submit();
        }
    });
}





