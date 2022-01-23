signalDrawing = false;
var x;
var y;

function mirror() {
    document.getElementById("mydrawing").addEventListener("mousedown", mouseDown);
    document.getElementById("mydrawing").addEventListener("mouseup", mouseUp);
    document.getElementById("mydrawing").addEventListener("mousemove", mouseMove);
}

function mouseMove(e) {
    if (signalDrawing == true) {
        var Drawing = document.getElementById("mydrawing");
        var ctx = Drawing.getContext("2d");
        ctx.moveTo(x, y);
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();

        x = e.offsetX;
        y = e.offsetY;
    }

    document.getElementById("xCoord").innerHTML = x;
    document.getElementById("yCoord").innerHTML = y;
}

function mouseDown(e) {
    if (e.which == 1) {
        signalDrawing = true;

        x = e.offsetX;
        y = e.offsetY;
    }
}

function mouseUp(e) {
    if (e.which == 1) {
        signalDrawing = false;
    }
}