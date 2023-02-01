$(start);

function start() {

    //Create the select
    mySelect = $("<select>");
    mySelect.attr("id", "mySelectID");

    //Create the option "Choose Animal"
    let myOptionSelect = $("<option>");
    myOptionSelect.html("Choose Animal");
    myOptionSelect.attr("id", "myOptionSelectID");
    myOptionSelect.val("-1");

    //Append that option into the select
    mySelect.append(myOptionSelect);

    //Options with all possible animals
    arrOptions = [
        "Cat",
        "Dog",
        "Frog"
    ];

    //Loop through that arr and appending the options into the select
    //i starts by0, bcs array starts by 0
    for (let i = 0; i <= arrOptions.length - 1; i++) {
        let myOption = $("<option>");
        myOption.val(arrOptions[i]);
        myOption.html(arrOptions[i]);
        mySelect.append(myOption);
    }

    //Create img element
    myImg = $("<img>");
    myImg.attr("id", "myImgID");

    //Append the select and the img to the body
    $("body").append(mySelect);
    $("body").append(myImg);


    //If the user selects something this runs
    $("#mySelectID").bind("change", function () {
        $("#myOptionSelectID").remove(); //Remove the first option

        ValueSelected = $("#mySelectID").val(); //Gets the val selected

        $("#myImgID").attr("src", ValueSelected + ".jpg"); //makes the src of the img = to the value selected + .jpg for the img file
    });
}