signalDrawing = false;
var x = 0;
var y = 0;
buttonState = false;
var myColorChoice = 1;
var myCanvasImageData;
var ctx;
let possibleColor = ["black", "red", "blue", "green", "yellow"]

 

function FirstDrawing()
{
    ctx = document.getElementById("canvas").getContext("2d");
    document.getElementById("canvas").addEventListener("mousedown", myMouseDown);
    document.getElementById("canvas").addEventListener("mouseup", stopDrawing);
    document.getElementById("canvas").addEventListener("mousemove", mouseMoving);
    document.getElementById("btn").addEventListener("click", NoDraw);

 

    for(i=0;i<possibleColor.length;i++)
        {
            let newcolor = document.createElement("div");
            newcolor.classList.add("box");
            newcolor.style = "background-color:" + possibleColor[i];
            newcolor.id = "colorpick" + possibleColor[i]; 
            document.body.append(newcolor);
            let myFunctionCall = SomeColorChanges.bind(null, possibleColor[i]);
            newcolor.addEventListener("click", myFunctionCall)
            //document.getElementById("colorpick" + possibleColor[i]).addEventListener("click", myFunctionCall);
        }
        
    /* alternative
    for(currentcolor of colors)
    {
        let newcolor = document.createElement("div");
        newcolor.classList.add("box");
        newcolor.style = "background-color:" + currentcolor;
        document.body.append(newcolor);
    }
    */
}

 

function SomeColorChanges(pickedColor)
{
    myColorChoice = pickedColor;
    for(color of possibleColor)
    {
        document.getElementById("colorpick" + color).style = "background-color:" + color;
    }
    document.getElementById("colorpick" + pickedColor).style = "border: solid 5px yellow; background-color:" + pickedColor;
}

 


function mouseMoving(e)
{
    if(signalDrawing == true)
    {
        //drawline(context, x, y, e.offsetX, e.offsetY);
        ctx.putImageData(myCanvasImageData, 0, 0);
        //let mydrawing = document.getElementById("canvas");
        //let ctx = mydrawing.getContext("2d");
        ctx.beginPath();
        ctx.strokeStyle = myColorChoice;
        ctx.moveTo(x,y);
        ctx.lineTo(e.offsetX,e.offsetY);
        //x = e.offsetX; normal drawing
        //y = e.offsetY;
        ctx.stroke();
    }
    document.getElementById("xCoord").innerHTML = x;
    document.getElementById("yCoord").innerHTML = y;
}

 

function stopDrawing(e)
{
    if(e.which==1)
    {
        signalDrawing = false;
    }
}

 

function myMouseDown(e)
{
    if(e.which==1)
    {
        if(!buttonState)
        {
            signalDrawing = true;
            x = e.offsetX;
            y = e.offsetY;
            //alert("Left mouse button down")
            var canvas = document.getElementById("canvas");
            var width = canvas.width;
            var height = canvas.height;
            myCanvasImageData = ctx.getImageData(0, 0, width, height);
        }
    }
}

 

function NoDraw()
{
    if(!buttonState)
    {
        document.getElementById("btn").innerHTML = "Start drawing";
    }
    else
    {
        document.getElementById("btn").innerHTML = "Stop drawing";
    }
    buttonState = !buttonState;
}