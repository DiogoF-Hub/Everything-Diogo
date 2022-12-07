$("<div>") //create element div --- works with any tag
$("div") //selects every div --- works with any tag (ex: body)
$("#div") //select a tag with the id = "div"
$(".div") //select every tag with the class = "div"



$(Start); //Run the function Start after the document was 100% loaded
function Start() {

}



a.val() //a will be equal to the val of that variable
a.val("123") //the value of a will be equal to "123"



a.attr("id", "bla") //the id of a will be "bla"------------This can be used with any atribute like class, id, name ETC



a.html() //a will be equal to what is written the tag----------- Ex: <div>This is a div</div> --- then a = This is a div
a.html("This is 1TPIFI") //This will overwrite the div ------- Ex before: <div>This is a div</div> ---- after: <div>This is 1TPIFI</div>



a.append(b) //This will put b inside a ----- ex: a  is a empty div and then b is a p tag with something written = <div> <p>something written</p> </div>
a.prepend(c) //It appends in the start and not at the end like append----Lets say that a is = <div> <p>something written</p> </div> and c = "There is " ---- a after the prepend = <div> There is <p>something written</p> </div>



a.remove() //it removes from HTML



//on works with change, click , and other js events that we learned
//2 ways of doing this:
a.on("change", functionName);
//or
a.on("change", function () {
    //write here the code for the function, so its an unamed function
});



//for loop in JS
for (let i = 0; i <= 5; i++) {

}