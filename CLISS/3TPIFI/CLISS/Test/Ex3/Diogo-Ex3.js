function CheckDivisibility() {
    selectedoption = document.getElementById("MySelectList").value;
    UserInput = document.getElementById("input").value;
    remainder = Number(UserInput) % Number(selectedoption);

    if (remainder == 0) {
        alert("You are right!")
    } else {
        alert("You don’t know anything about math")
    }

}

