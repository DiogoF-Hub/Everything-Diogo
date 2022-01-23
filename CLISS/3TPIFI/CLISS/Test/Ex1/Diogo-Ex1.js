function Compute() {
    ANumber = document.getElementById("A").value;
    BNumber = document.getElementById("B").value;

    result = (Number(ANumber) + Number(BNumber)) * (Number(ANumber) - Number(BNumber));

    alert(result);
}