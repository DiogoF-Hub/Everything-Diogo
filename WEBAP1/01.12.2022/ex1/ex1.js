$(Start);

arr = ["a", "b", "c", "d"];

function Start() {
    let mySelect = $("<select>");

    for (let i = 0; i < arr.length; i++) {
        let myoption = $("<option>");
        myoption.val(arr[i]);
        myoption.attr("id", arr[i]);
        myoption.html(arr[i]);

        mySelect.append(myoption)
    }

    $("body").append(mySelect);



    let mybutton = $("<button>");
    mybutton.html("Delete");
    $("body").append(mybutton);


    let myOutputDiv = $("<div>");
    $("body").append(myOutputDiv);


    mybutton.on("click", function () {
        let myCurrentVal = mySelect.val();
        $("#" + myCurrentVal).remove();


        let myP = $("<p>");
        myP.html(myCurrentVal);
        myOutputDiv.append(myP);
    });

}
