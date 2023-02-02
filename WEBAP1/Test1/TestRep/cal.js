$(start);

let A = "";
let B = "";
let Result = "";
let operation = 0;

function start() {

    MyInput = $("<input>");
    $("body").append(MyInput);


    for (let i = 0; i <= 9; i++) {
        let myButton = $("<button>");
        myButton.html(i);
        myButton.on("click", function () {
            if (MyInput.val() == "error") {
                MyInput.val("");
            }
            MyValBefore = MyInput.val();
            MyValAfter = MyValBefore + i;
            MyInput.val(MyValAfter);
        });
        $("body").append(myButton);
    }


    ClearButton = $("<button>");
    ClearButton.html("C");
    ClearButton.on("click", function () {
        A = "";
        B = "";
        operation = 0;
        MyInput.val("");
    });
    $("body").append(ClearButton);


    PlusButton = $("<button>");
    PlusButton.html("+");
    PlusButton.on("click", function () {
        if (A == 0) {
            A = MyInput.val();
            MyInput.val("");
            operation = 1;
        }
    });
    $("body").append(PlusButton);


    MinusButton = $("<button>");
    MinusButton.html("-");
    MinusButton.on("click", function () {
        if (A == 0) {
            A = MyInput.val();
            MyInput.val("");
            operation = 2;
        }
    });
    $("body").append(MinusButton);


    EqualButton = $("<button>");
    EqualButton.html("=");
    EqualButton.on("click", function () {
        B = MyInput.val();
        if (A != "" && B != "") {

            if (operation != 0) {
                if (operation == 1) {
                    Result = parseInt(A) + parseInt(B);
                }

                if (operation == 2) {
                    Result = parseInt(A) - parseInt(B);
                }
            } else {
                MyInput.val("error");
            }

            MyInput.val(Result);
        } else {
            MyInput.val("error");
        }
    });
    $("body").append(EqualButton);
}