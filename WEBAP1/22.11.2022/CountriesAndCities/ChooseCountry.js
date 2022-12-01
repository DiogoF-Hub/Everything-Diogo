$(window).on("load", start);
// the same with:
//$(cocoMelon);

function start() {
    //alert("I started");
    // I NEED TO FILL IN THE COUNTRIES SELECT LIST
    $.get("getCountries.php", doneLoadingData);
    //$("#CountrySelect").load("getCountries.php");

    $("#CountrySelect").on("change", selectWasChanged);
}

function doneLoadingData(dataThatWasLoaded) {
    //alert(dataThatWasLoaded);
    $("#CountrySelect").append(dataThatWasLoaded);
}

/*
// Unnamed function version:
function start() {
    $("#CountrySelect").on("change", function() {
    $("#Choose").remove();
});
}
*/

function selectWasChanged() {
    $("#Choose").remove();

    let myCurrentCountrySelect = $("#CountrySelect").val();

    /*
    let myResultingCities = $("#resultingCities");
    myResultingCities.load("getCities.php?Country=" + myCurrentCountrySelect);
    */
    // INSTEAD OF LOAD, we can use $.get

    $.get("getCities.php", { Country: myCurrentCountrySelect }, doneLoadingCities);

    $("body").append(myResultingCities);
}

function doneLoadingCities(citiesData) {
    $("#resultingCities").html(citiesData);
}
