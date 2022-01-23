function FindNthFibo() {
    userinput = document.getElementById("myinput").value;

    var a = 0, b = 1, f = 1;
    for (i = 2; i <= userinput; i++) {
        f = a + b;
        a = b;
        b = f;
    }

    result = (Number(f))
    document.getElementById("myDiv").innerHTML = 'The ' + userinput + '’th Fibonnaci number is ' + result;
}
