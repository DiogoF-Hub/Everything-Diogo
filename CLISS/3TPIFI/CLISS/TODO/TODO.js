var task = [];
function buttonAdd() {
    inputAdd = document.getElementById("addTask").value;
    task.push(inputAdd);
    document.getElementById("taskToDo").innerHTML = ""
    for (let i = 0; i < task.length; i++) {
        document.getElementById("taskToDo").innerHTML += "<li>" + task[i] + "</li>";
    }
}

function buttonRemove() {
    b = Number(document.getElementById("removeTask").value);

    //Delete the list
    //-1 bcs the array starts from 0
    task.splice(b - 1, 1);
    document.getElementById("taskToDo").innerHTML = "";

    //Generate it again
    for (let i = 0; i < task.length; i++) {
        document.getElementById("taskToDo").innerHTML += "<li>" + task[i] + "</li>";
    }
}