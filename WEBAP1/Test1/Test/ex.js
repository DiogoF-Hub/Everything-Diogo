$(Start);


function Start() {
    let mybutton = $("<button>");
    mybutton.html("Create list");
    mybutton.attr("id", "mybutton");

    let myinput = $("<input>");
    myinput.attr("type", "number");
    //myinput.attr("id", "myinput");

    $("body").append(myinput);
    $("body").append(mybutton);

    mybutton.on("click", function () {

        if (!$("#myselectList").length) {
            n = myinput.val()

            if (n > 2) {
                let myselectList = $("<select>");
                myselectList.attr("id", "myselectList");

                for (let i = 2; i <= n; i++) {
                    let myoption = $("<option>");
                    myoption.html(i);
                    myoption.val(i);
                    myselectList.append(myoption);
                }

                $("body").prepend(myselectList); //APPEND

                myinput.remove();
                mybutton.html("GO");
            }

        } else {
            SelectVal = $("#myselectList").val();
            $("#myselectList").remove();
            $("#mybutton").remove();

            for (let i = 1; i <= SelectVal; i++) {
                let manyInputs = $("<input>");
                manyInputs.attr("id", i);
                let manyButtons = $("<button>");
                manyButtons.html("NEXT");

                manyButtons.on("click", function () {
                    A = $("#" + i);

                    if (i == SelectVal) {
                        test = 1;
                    } else {
                        test = i + 1;
                    }

                    B = $("#" + test); //Here was not working bcs instead of test i was writting i+1

                    temp = A.val();

                    A.val(B.val());
                    B.val(temp);

                    //My code before your help
                    /*if(i != SelectVal){
                        test = i+1;
                        $("#"+test).val(myval);
                        $("#"+i).val(mypreviousval);
                    }else{
                        test = 1;
                        $("#"+test).val(myval);
                        $("#"+i).val(mypreviousval);
                    }*/
                });

                $("body").append(manyInputs);
                $("body").append(manyButtons);
            }
        }
    });
}