var cities =["Luxembourg","Esch","Wiltz","Differdange"]

function arrays()
{ 
    for(let i=0;i<cities.length;i++)
    {
    document.getElementById("ListOfCities").innerHTML += "<option>"+ cities[i]+"</option>";
    }
    
    for(let i=cities.length-1;i>=0;i--)
    {
        document.getElementById("ListOfCities").innerHTML += "<option>"+ cities[i] + "</option>"
    }
}