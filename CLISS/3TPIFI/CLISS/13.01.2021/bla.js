function userInput() {
    let n = 7;

    for (let i = 1; i <= n; i++) {
        s = i * (i + 1);

        document.getElementById("userInput").value = n;
        document.getElementById("dataHere").innerHTML += i + '<br>';
    }


}