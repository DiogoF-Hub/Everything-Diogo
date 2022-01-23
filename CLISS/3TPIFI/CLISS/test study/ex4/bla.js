clicks = 0;

function count() {
    clicks++;
    document.getElementById("count").innerHTML = clicks;

    if(clicks==10){
        document.getElementById("classChange").classList.replace("redbox", "bluebox");
        clicks=0;
    } 
}