<?php
$host = "localhost";
$user = "root";

$connection = new mysqli($host, $user, "", "countriesandcities");
$sqlSelect = $connection->prepare("SELECT * from countries");
$sqlSelect->execute();
$result = $sqlSelect->get_result();
while ($row = $result->fetch_assoc()) {
?>
    <option value="<?= $row["CountryID"] ?>"><?= $row["CountryName"] ?></option>
<?php
}
?>