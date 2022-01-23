function drawSomething()
{
    var canvas =document.getElementById("myDrawing")
    var ctx = canvas.getContext("2d")
    ctx.beginPath()
    ctx.moveTo(0, 150) // starting point House
    ctx.lineTo(0, 300)
    ctx.lineTo(200, 300)
    ctx.lineTo(200, 150)
    ctx.lineTo(0, 150)
    ctx.lineTo(100, 0)
    ctx.lineTo(200, 150)
    ctx.lineTo(200, 0)
    ctx.lineTo(100, 0)
    ctx.lineTo(0, 0)
    ctx.lineTo(0, 150)

    ctx.moveTo(80, 300) // starting point Door
    ctx.lineTo(80, 240)
    ctx.lineTo(120, 240)
    ctx.lineTo(120, 300)

    ctx.moveTo(140, 240) // starting point Window
    ctx.lineTo(180, 240)
    ctx.lineTo(180, 200)
    ctx.lineTo(140, 200)
    ctx.lineTo(140, 240)
    ctx.stroke()
}