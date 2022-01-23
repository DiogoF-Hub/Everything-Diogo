var tasks = [];
function buttonAdd() {
    //Take from the input and put into the array
    inputAdd = document.getElementById("addTask").value;
    if (inputAdd.value.length == 0) {
        alert("Please input a Value")
    } else {
        tasks.push(inputAdd);

        //Delete what is inside of the input when its added so no need to delete to add the next one
        document.getElementById("addTask").value = "";

        //Do the select and li
        refreshList();
    }
}

function refreshList() {
    //Option element for the first option of select
    let option0 = document.createElement("option");
    //-1 bcs of 47, so it will work like and ID but instead its a value
    option0.value = -1
    option0.text = "Select"

    //Clear ol list
    document.getElementById("taskToDo").innerHTML = "";

    //Clear select list
    document.getElementById("MyList").innerHTML = "";

    //After clearing the select list the first option element should be added again into the select tag
    document.getElementById("MyList").append(option0);

    //Take all to do from array and add it in ol and select tag
    for (let i = 0; i < tasks.length; i++) {
        //Write every task into the ol tag by using li tag
        document.getElementById("taskToDo").innerHTML += "<li>" + tasks[i] + "</li>";

        //OptionToDo element for the select tag instead of using a string
        let optionToDo = document.createElement("option");
        optionToDo.value = i;
        optionToDo.text = tasks[i];
        document.getElementById("MyList").append(optionToDo);
    }
}

function buttonRemove() {
    //Take what is selected from the select tag
    selectedValue = document.getElementById("MyList").value;

    //If selectedValue = -1 it means the select option is selected and you dont want to delete that option
    if (selectedValue == -1) {
        alert("Select one before deleting")
    } else {

        //Delete the selected inside the array
        tasks.splice(selectedValue, 1);

        //Do it again without the deleted one
        refreshList();
    }
}

function buttonConfirmDeleteAll() {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        DeleteAll();
    } else {

    }
}

function DeleteAll() {

    //Delete everything from the array
    tasks.splice(0, tasks.length);

    //Execute again without anything inside the array
    refreshList();

}