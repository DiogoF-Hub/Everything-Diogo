function DoCompute() {
    let a = 501;
    let b = 699;
    let sum = 0;
    for (let i = a; i <= b; i++) {
        sum = sum + i;
        document.getElementById("result").innerHTML += "<div>" + sum + "</div>";
    }
}