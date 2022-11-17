//alert("Welcome");

//window.addEventListener("load", Start); // NORMAL JS
$(Start); // JQUERY

function Start() {
    // document.getElementById("myElement").innerHTML = "Hello World";
    /*$("#myElement").html("Hello World");// select by id
    $(".myClass").html("This is a div");// select by class
    $("p").html("I just replaced all divs");// select by tag name*/


    for (i = 1; i <= 5; i++) {
        let myJQDiv = $("<div>" + i + "</div>");
        $("#myElement").append(myJQDiv);
    }
}
