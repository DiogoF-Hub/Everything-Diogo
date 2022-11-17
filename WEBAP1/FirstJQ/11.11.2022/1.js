$(Start);
function Start() {
    arr = ["Sam", "Rui", "Diogo"];

    for (i = 0; i < arr.length; i++) {
        let opt = $("<option>" + arr[i] + "</option>");
        $(opt).attr("value", i);
        $("#MySelect").append(opt);
    }
}
