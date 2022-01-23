function Computetemperature() {
    tf = document.getElementById("TempF").value;
    ct = Number((tf - 32) / (9 / 5));
    document.getElementById("ComputedResult").innerHTML = ct;
    if (ct < 0) {
        alert("Its FREEZING");
    }
    else {
        if (ct <= 10) {
            alert("It's chilly");
        }
        else {
            if (ct <= 25) {
                alert("It's normal");
            }
            else {
                alert("It's hot");
            }
        }
    }
}