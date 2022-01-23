y_values = []


function BtnPress() {
    let AString = document.getElementById("A").value
    let A = Number(AString)
    let BString = document.getElementById("B").value
    let B = Number(BString)
    if (A < B) {
        for (let x = A + 1; x < B; x++) {
            let y = x * x + x - 10
            y_values.push(y)
        }
    }
    else {
        alert("Inavalid interval !")
    }
    document.getElementById("container").innerHTML = y_values
}

function Countnegatives() {
    let negativenumbers = 0
    for (let i = 0; i < y_values.length; i++) {
        if (y_values[i] < 0) {
            negativenumbers = negativenumbers + 1
        }
    }
    document.getElementById("negativescount").innerHTML = negativenumbers
}