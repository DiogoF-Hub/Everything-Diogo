//alert("Welcome");

//$(document).ready(()=>{})
//Window.addEventListener("load", Start); // NORMAL JS
$(Start); //JQUERRY


function Start(){
    //document.getElementById("myElement").innerHTML = "Hello World"; NORMAL JS
   /* $("#myElement").html("Hello World"); // select by id
    $(".myClass").html("This is a div"); // select by class
    $("div").html("I just replaced all divs"); // select by tag name

    let myJQDiv = $("<div>This is a div created from code</div>");
    $("#myElement").append(myJQDiv);
*/
//add inside the Element div multiple divs with each of them containing a nmber from 1 to 5

for(let i=1; i<=5; i++){
    let myJQDiv = $("<div>" +i+ "</div>");
    $("#myElement").append(myJQDiv);

}

}