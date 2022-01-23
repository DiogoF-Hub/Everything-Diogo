y_values = [];

function CheckValues() {
    A = document.getElementById("A").value;
    let ANumber = Number(A);

    B = document.getElementById("B").value;
    let BNumber = Number(B);

    if (ANumber > BNumber) {
        for (i = ANumber+1; i < BNumber; i++) {
            y = i * i + i - 10;
            y_values.push(y);
        }
    }

    else {
        alert("Invalid interval")
    }

    document.getElementById("Mydiv").innerHTML = y_values;
}