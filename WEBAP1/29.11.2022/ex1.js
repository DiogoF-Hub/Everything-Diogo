/*
-Create a select list where there is some animals
-When the user selects a animal, an input will appear.
-From that input the user must write how many of that animal will appear as image in a line and all of them must be numered.

ALL THE HTML CODE MUST BE INSERTED FROM JS
*/

$(Start);
var AnimalsArr = { 1: "cat", 2: "dog", 3: "horse" };


function Start() {
    let myAnimalsSelect = $("<select>");
    myAnimalsSelect.attr("id", "animalsSelect");
    myAnimalsSelect.on("change", AnimalselectWasChanged);

    let myAnimalChoose = $("<option>");
    myAnimalChoose.html("Choose an Animal");
    myAnimalChoose.val("-1");
    myAnimalChoose.attr("id", "myAnimalChoose");

    myAnimalsSelect.append(myAnimalChoose);


    for (let i = 1; i <= Object.keys(AnimalsArr).length; i++) {
        let myAnimalOption = $("<option>");
        myAnimalOption.attr("value", i);
        myAnimalOption.html(AnimalsArr[i]);
        myAnimalsSelect.append(myAnimalOption);
    }


    $("body").append(myAnimalsSelect);
}


function AnimalselectWasChanged() {
    if (!$('#animalsInput').length) {
        let myInput = $("<input>");
        myInput.attr("type", "number");
        myInput.attr("placeholder", "Write a number");
        myInput.attr("id", "animalsInput");


        let myButton = $("<button>");
        myButton.html("Go");
        myButton.on("click", ButtonWasClicked);

        $("body").append(myInput);
        $("body").append(myButton);
    }
}


function ButtonWasClicked() {
    inputVal = $("#animalsInput").val();
    selectVal = $("#animalsSelect").val();

    if (inputVal == "" || !$.isNumeric(inputVal)) {
        alert("Write a number");
        $("#animalsInput").val("");
    } else {
        if (parseInt(inputVal) in AnimalsArr) {

            $("#myAnimalChoose").remove();

            myNewLineDiv = $("<div>");


            for (let i = 1; i <= inputVal; i++) {
                let myImg = $("<img>");
                myImg.attr("src", AnimalsArr[selectVal] + ".jpg")

                myNewLineDiv.append(i);
                myNewLineDiv.append(myImg);
            }


            $("#animalsInput").val("");

            $("body").append(myNewLineDiv);
        }
    }



}