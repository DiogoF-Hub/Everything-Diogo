$(start);

function start() {
    $("#Login").on("click", loginNow);
}


function loginNow() {
    $.ajax({
        url: "http://localhost/GitHub/Everything-Diogo/WEBAP1/13.12.2022/ServerResponse.php",
        data: { User: $("#UserName").val(), Psw: $("#Password").val() },
        success: successCall,
    });
}


function successCall(dataBack) {
    $("#AnswerFromServer").html(dataBack)
}