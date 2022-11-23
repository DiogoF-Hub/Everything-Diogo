$(start);

function start() {
    $("#CountrySelect").on("change", selectWasChanged);
}


/*
// Unnamed function version:
function start (){
    $("#CountrySelect").on("change", function(){
        $("Choose").remove();
    });
}

*/

function selectWasChanged() {
    $("#choose").remove();

    let myCurrentCountrySelect = $("#CountrySelect").val;
    let myResultingCities = $("#resultingCities");

    myResultingCities.load("getCities.php?Country=" + myCurrentCountrySelect);
    $("body").append(myResultingCities);

}


