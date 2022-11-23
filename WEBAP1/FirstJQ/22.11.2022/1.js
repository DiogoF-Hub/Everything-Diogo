$(function () {
    $("#Send").click(function () {
        let myNewDivMsg = $("<div>");
        // GET/READ the contents of the input box
        myNewDivMsg.append($("#UserMsg").val());    //GET
        myNewDivMsg.addClass("EachMessage");
        $("#Messages").append(myNewDivMsg);
    });

    // SET the contents of the input box
    //when the second button was pressed
    $("#SetInput").click(function () {
        // let us SET (change) the contents of the button tag:
        alert("Your button contains the text: " + ("#SetInput").html()); // GET
        $("#SetInput").html("New text"); //SET
        $("UserMSG").val("Nothing");    //SET
    });
});