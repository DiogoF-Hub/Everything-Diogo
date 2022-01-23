

function DoDisplay()
{
    var arrayOfCities = ["Luxembourg city", "Esch","Wiltz","Junglinster","Wormeldange","bla","Yet another city","aaa"];


    document.getElementById("Where").innerHTML = "";
    for(let i=0;i<arrayOfCities.length;i++)
    {
        let cityNumber = i+1;
        document.getElementById("Where").innerHTML += cityNumber + " -" + arrayOfCities[i] + "<BR>";
    }    

}

function DoDisplayReversed()
{
    document,
}