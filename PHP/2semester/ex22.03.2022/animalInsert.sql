DROP DATABASE animalsinsert;
create database animalsinsert;
use animalsinsert;

create TABLE Animals(
    AnimalID int NOT NULL AUTO_INCREMENT,
    AnimalName VARCHAR(20) unique,
    Continent VARCHAR(20),
    primary key(AnimalID)
);

