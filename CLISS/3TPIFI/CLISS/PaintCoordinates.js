signalDrawing = false;
var x = 0;
var y = 0;
buttonState = false;
var myColorChoice = 1;
var myCanvasImageData;
var ctx;
let possibleColor = ["black", "red", "blue", "green", "yellow", "brown", "pink"]
 
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
 document.getElementById("colorpick").append(newcolor);
 let myFunctionCall = SomeColorChanges.bind(null, possibleColor[i]);
 newcolor.addEventListener("click", myFunctionCall)
 }
}
 
function SomeColorChanges(pickedColor)
{
 myColorChoice = pickedColor;
 document.getElementById("colorpick").style = "background-color:" + myColorChoice;

 document.getElementById("colorpick").style = "border: solid 5px cyan; background-color:" + pickedColor;
}
 
function mouseMoving(e)
{
 if(signalDrawing == true)
 {
 let mydrawing = document.getElementById("canvas");
 let ctx = mydrawing.getContext("2d");
 ctx.beginPath();
 ctx.strokeStyle = myColorChoice;
 ctx.moveTo(x,y);
 ctx.lineTo(e.offsetX,e.offsetY);
 ctx.stroke();
 }
 x = e.offsetX; //normal drawing
 y = e.offsetY;
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
 var canvas = document.getElementById("canvas");
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