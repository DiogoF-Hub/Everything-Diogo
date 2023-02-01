$(start);

function start() {

    //arr with the possible options
    arr = [
        "Car.jpg",
        "Dog.jpg",
        "Cat.jpg"
    ]

    //create select element
    mySelectList = $("<select>");
    mySelectList.attr("id", "mySelectListID");

    //loop through the arr and putting the option into the select
    for (let i = 0; i <= arr.length - 1; i++) {
        let myOption = $("<option>");
        myOption.val(arr[i]);
        myOption.html(arr[i]);
        mySelectList.append(myOption);
    }

    //create input element
    myInput = $("<input>");
    myInput.attr("id", "myInputID");
    myInput.attr("type", "number");//EXTRA not needed

    //create button element
    myButton = $("<button>");
    myButton.html("Add");
    myButton.attr("id", "myButtonID");

    //create div element where I put the imgs
    myDivImgs = $("<div>");
    myDivImgs.attr("id", "myDivImgsID");

    //append everything to the body
    $("body").append(mySelectList);
    $("body").append(myInput);
    $("body").append(myButton);
    $("body").append(myDivImgs);


    //when the button is clicked run this
    $("#myButtonID").bind("click", function () {
        $("#myDivImgsID").html(""); //Clear the div

        selectVal = $("#mySelectListID").val(); //get the selected value
        inputVal = $("#myInputID").val(); //get the input value

        for (let i = 1; i <= inputVal; i++) { //loop from 1 to the number that the user typed
            //Create the img element with the src from the select and append to the div
            let myImg = $("<img>");
            myImg.attr("src", selectVal);
            $("#myDivImgsID").append(myImg);
        }
    });
}