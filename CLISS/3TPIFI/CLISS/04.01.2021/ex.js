function startCode() {
    m = 50;
    if (m > 0) {
        for (let i = m; i >= 0; i--) {
            document.getElementById("dataHere").innerHTML += i + '<br>'
        }
    }
    else {
        for (let i = m; i <= 0; i++) {
            document.getElementById("dataHere").innerHTML += i + '<br>'
        }
    }
}