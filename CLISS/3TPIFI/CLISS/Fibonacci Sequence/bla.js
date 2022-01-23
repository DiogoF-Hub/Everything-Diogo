

function DoCompute()
{  
    let a = 0;
    let b = 1;
    let c = b+a;

    for(let i=0;i<100;i++)
    {
        a = b;
        b = c;
        c = a+b;
        document.getElementById("result").innerHTML += a +" , ";
    }
}