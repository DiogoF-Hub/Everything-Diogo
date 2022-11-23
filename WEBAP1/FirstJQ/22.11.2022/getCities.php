<select>
    <?php
    // This is a script that will ANSWER a question:
    //WHAT ARE the cities that belong to "THIS" country?
    //"THIS" country must be given as a GET PARAMETER

    if (isset($_GET["Country"])) {
        $host = "localhost";
        $user = "root";

        $connection = new mysqli($host, $user, "", "countriesandcities");
        $sqlSelect = $connection->prepare("SELECT * from cities where CountryID=?");
        $sqlSelect->bind_param("i", $_GET["Country"]);
    } else {
    ?>
        <option>Please give me a country</option>
    <?php
    }

    ?>

</select>