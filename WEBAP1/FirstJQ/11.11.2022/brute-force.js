$(start);

function start() {
    array = ["a", "b", "c"];
    results = [];

    $("#normal").html(array.toString());

    for (var i = 0; i < array.length; i++) {
        for (var b = 0; b < array.length; b++) {
            if (i == b) {
                results.push($.trim(array[i] + " "));
            } else {
                results.push($.trim(array[i] + ' ' + array[b] + " "));
            }
        }
    }

    $("#result").html(results.toString());
}