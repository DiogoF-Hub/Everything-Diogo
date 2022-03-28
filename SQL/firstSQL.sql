drop database dud;
create database dud;
use dud;
CREATE TABLE Countries (
    CountryID int not null AUTO_INCREMENT,
    CountryName varchar(255),
    PRIMARY KEY (CountryID)
);
INSERT INTO Countries (CountryName)
VALUES("Luxembourg");
INSERT INTO Countries (CountryName)
VALUES("France");
CREATE TABLE PPL (
    PersonID int not null AUTO_INCREMENT,
    PersonName varchar(255),
    CountryOfPerson int,
    PRIMARY KEY (PersonID),
    FOREIGN KEY (CountryOfPerson) REFERENCES Countries(CountryID)
);
INSERT INTO PPL (PersonName, CountryOfPerson)
VALUES("John", 1);
INSERT INTO PPL (PersonName, CountryOfPerson)
VALUES("Angelina", 2);