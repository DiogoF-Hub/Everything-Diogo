function checkNames(a) {
    if (!/^[ a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ'`'\-]+$/.test(a)) {
        return false;
    }
}


function checkEmail(a) {
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(a)) {
        return false;
    }
}


function checkPhoneNumber(a) {
    if (!/^(\+|00)]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/.test(a)) {
        return false;
    }
}

async function emailtaken(a) {//this is async so just waits until the line 149 as finished that means, tun the whole test func
    let free = true; //flag for the return
    async function test(a) { //func inside a func bcs we need the return    // This one just goes on only after the whole ajax func as finished
        await $.ajax({
            url: "http://localhost/GitHub/Everything-Diogo/PIF/Website/PHP/emailTaken.php",
            type: "POST",
            data: ({
                emailTaken: a,
            }),
            success: function (parameter) {
                bla = parameter.data.Message;

                if (bla == "1") {
                    //$("#email").parent().children("div").html("This email is already taken");
                    free = false;
                }

            },
        });
    }
    await test(a);

    return free;
}
