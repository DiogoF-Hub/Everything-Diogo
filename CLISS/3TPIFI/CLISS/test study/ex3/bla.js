function CalculateDelta() {
    A = document.getElementById("A").value;
    B = document.getElementById("B").value;
    C = document.getElementById("C").value;
    Delta = (B * B) - (4 * A * C);
    document.getElementById("result").innerHTML = Delta;

    if (Delta < 0) {
        document.getElementById("box").innerHTML = '<div class="box redBox"></div>';
    } else {
        document.getElementById("box").innerHTML = '<div class="box blueBox"></div>';
    }
}