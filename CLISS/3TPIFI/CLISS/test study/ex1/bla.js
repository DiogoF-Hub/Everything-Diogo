function Mybutton() {
    tf = document.getElementById("Myinput").value;
    tc = (tf - 32) / (9 / 5);
    document.getElementById("Mydiv").innerHTML = tc;
    if (tc < 0) {
        alert("Its FREEZING")
    } else {
        if (tc <= 10) {
            alert("Its chilly")
        } else {
            if (tc <= 25) {
                alert("It's normal")
            } else {
                alert("It's hot")
            }
        }
    }
}