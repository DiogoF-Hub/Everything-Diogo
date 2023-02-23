$(start);

var cipher = {
    'A': 'W',
    'B': 'X',
    'C': 'Y',
    'D': 'Z',
    'E': 'A',
    'F': 'B',
    'G': 'C',
    'H': 'D',
    'I': 'E',
    'J': 'F',
    'K': 'G',
    'L': 'H',
    'M': 'I',
    'N': 'J',
    'O': 'K',
    'P': 'L',
    'Q': 'M',
    'R': 'N',
    'S': 'O',
    'T': 'P',
    'U': 'Q',
    'V': 'R',
    'W': 'S',
    'X': 'T',
    'Y': 'U',
    'Z': 'V'
};


function start() {
    $(".button").bind("click", function () {
        bla = $(this).attr('id');
        result = "";

        if (bla == "text") {
            str = $("#TextInput").val().toUpperCase();

            for (var i = 0; i < str.length; i++) {
                if (str[i] != " ") {
                    result += cipher[str[i]];
                } else {
                    result += " ";
                }

            }
            $("#result1").html(result);
        } else {
            str = $("#CipherInput").val().toUpperCase();

            for (var i = 0; i < str.length; i++) {
                if (str[i] != " ") {
                    $.each(cipher, function (key, value) {
                        if (value === str[i]) {
                            result += key;
                            return;
                        }
                    });
                } else {
                    result += " ";
                }

            }
            $("#result2").html(result);
        }
    });
}