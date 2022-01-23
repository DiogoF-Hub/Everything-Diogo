function types() {
    selectedvalue = document.getElementById("myselect1").value;

    if (selectedvalue == 1) {
        document.getElementById("newselectdiv").innerHTML = '<select name="types" id="dogselect"> <option value="1">German Shepherd</option> <option value="2">Bulldog</option> <option value="3">Chihuahua</option> </select>'
    } else {
        if (selectedvalue == 2) {
            document.getElementById("newselectdiv").innerHTML = '<select name="types" id="catselect"> <option value="1">Persian cat</option> <option value="2">Maine Coon</option> <option value="3">Siamese cat</option> </select>'
        } else {
            if (selectedvalue == 3) {
                document.getElementById("newselectdiv").innerHTML = '<select name="types" id="fishselect"> <option value="1">Siamese fighting fish</option> <option value="2">Common carp</option> <option value="3">Guppy</option> </select>'

            }
        }
    }

}



function displayAnimal() {
    selectedvalue = document.getElementById("myselect1").value;

    if (dogselect == 0) {
        dogvalue = document.getElementById("dogselect").value;
    } else {
        if (catselect == 0) {
            dogvalue = document.getElementById("catselect").value;
        } else {
            if (fishselect == 0) {
                fishvalue = document.getElementById("fishselect").value;
            }
        }
    }

    function displaytype();
}



function displaytype {
    if (dogvalue == 1) {
        document.getElementById("mydiv").innerHTML = '<img src="German Shepherd.jpg" alt="dog">'
    } else {
        if (dogvalue == 2) {
            document.getElementById("mydiv").innerHTML = '<img src="Bulldog.jpg" alt="dog">'
        } else {
            if (dogvalue == 3) {
                document.getElementById("mydiv").innerHTML = '<img src="Chihuahua.jpg" alt="dog">'
            } else {
                if (catvalue == 1) {
                    document.getElementById("mydiv").innerHTML = '<img src="Persian cat.jpg" alt="cat">'
                } else {
                    if (catvalue == 2) {
                        document.getElementById("mydiv").innerHTML = '<img src="Maine Coon.jpg" alt="cat">'
                    } else {
                        if (catvalue == 3) {
                            document.getElementById("mydiv").innerHTML = '<img src="Siamese cat.jpg" alt="cat">'
                        } else {
                            if (fishvalue == 1) {
                                document.getElementById("mydiv").innerHTML = '<img src="Siamese fighting fish.jpg" alt="fish">'
                            } else {
                                if (fishvalue == 2) {
                                    document.getElementById("mydiv").innerHTML = '<img src="Common carp.jpg" alt="fish">'
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}