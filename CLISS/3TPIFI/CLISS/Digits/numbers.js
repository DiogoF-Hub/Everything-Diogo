function PrintLastDigitAndReturnDividedNumberBy10(givenNumber) {
    let lastDigit = givenNumber%10;
    document.getElementById("output").innerHTML += lastDigit;
    //return Math.floor(givenNumber/10);

}

function ConvertNumber() {
    let n = Number(document.getElementById("givenNumber").value);

    document.getElementById("output").innerHTML = "";

    while (n > 0) {
        n = PrintLastDigitAndReturnDividedNumberBy10(n);
    }
}