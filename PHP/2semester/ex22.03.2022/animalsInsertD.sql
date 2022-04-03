drop database AnimalsInsert;
create database AnimalsInsert;
use AnimalsInsert;

create table Animals(
    AnimalId int NOT NULL AUTO_INCREMENT,
    AnimalName VARCHAR(20) unique,
    Continent VARCHAR(20),
    primary key (AnimalId)
);

