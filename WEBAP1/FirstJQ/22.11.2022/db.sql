drop database CountriesAndCities;
create database CountriesAndCities;

use CountriesAndCities;

CREATE TABLE Countries (
    CountryID int unique not null AUTO_INCREMENT,
    CountryName varchar(255) unique,
    PRIMARY KEY (CountryID)
);



create table Cities(
    CityId int unique not null AUTO_INCREMENT,
    CityName varchar(255) unique,
    PRIMARY KEY (CityId),
    CountryID int not null,
    FOREIGN KEY (CountryID) REFERENCES Countries(CountryID)
);

Insert into Countries(CountryName) Values("Germany");
Insert into Countries(CountryName) Values("France");
Insert into Countries(CountryName) Values("Belgium");

Insert into Cities(CityName,CountryID) Values("Berlin",1);
Insert into Cities(CityName,CountryID) Values("Frankfurt",1);
Insert into Cities(CityName,CountryID) Values("Trier",1);
Insert into Cities(CityName,CountryID) Values("Paris",2);
Insert into Cities(CityName,CountryID) Values("Dijon",2);
Insert into Cities(CityName,CountryID) Values("Arlon",2);
Insert into Cities(CityName,CountryID) Values("Bruxelles",3);
