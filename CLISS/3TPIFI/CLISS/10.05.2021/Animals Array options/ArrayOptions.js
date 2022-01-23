let arrayOptions = ["Cat", "Dog", "Turtle", "Horse", "Pig", "Cow", "Chicken", "Lion"];

let msCount = 0;

function loadarray() {
    let selectTag = document.createElement("select");
    selectTag.id = "MySelect";
    document.body.append(selectTag);


    for (let i = 0; i < arrayOptions.length; i++) {
        let optionTag = document.createElement("option");
        optionTag.value = arrayOptions[i];
        optionTag.text = arrayOptions[i];
        document.getElementById("MySelect").append(optionTag);
    }


    let button = document.createElement("button");
    button.append("Click Me");
    document.body.append(button);
    button.addEventListener("click", delayedClick);

    let divWithMs = document.createElement("div");
    divWithMs.id = "timer"
    document.body.append(divWithMs);
}

function delayedClick (){
    document.getElementById("timer").innerHTML = " ";
    setInterval(IncreaseAndDisplayMs, 10);
    setTimeout(alertSelected, 3000);
}

function IncreaseAndDisplayMs(){
    msCount += 10;
    document.getElementById("timer").innerHTML = msCount;
}

function alertSelected() {
    selectedValue = document.getElementById("MySelect").value;
    alert(selectedValue);
}


