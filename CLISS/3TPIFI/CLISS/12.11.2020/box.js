let number = 0
var currentcolorBox = "blueBox"
function addBox(){
    let stringBoxes = document.getElementById("input").value;
    let numberBoxes = Number(stringBoxes);
    for (let r =0; r < numberBoxes; r++) {
    if(currentcolorBox =="blueBox"){
        currentcolorBox = "redBox"
    }

    else
    if(currentcolorBox == "redBox"){
        currentcolorBox = "greenBox"
    }

    else
    if(currentcolorBox == "greenBox"){
        currentcolorBox = "blueBox"
    }


    number++;
    document.getElementById("bodyId").innerHTML += '<div class="box '+ currentcolorBox +'">'+ number +'</div>'
}
}