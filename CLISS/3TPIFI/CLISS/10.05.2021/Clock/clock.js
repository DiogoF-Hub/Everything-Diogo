let timeElapsed = 0;
let isClockRunning = false;

function StartFunction() { }

function ClockClick() {
    isClockRunning = !isClockRunning;
    if (isClockRunning) {
        returnValueOfSetInterval = setInterval(StartClock, 10);
        document.getElementById("clock").innerHTML = "Stop the clock";
    } else {
        clearInterval(returnValueOfSetInterval);
        document.getElementById("clock").innerHTML = "Start the clock";
    }
}

function StartClock() {
    timeElapsed += 10;
    document.getElementById("myTime").innerHTML = timeElapsed;
}