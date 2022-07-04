create database Wsers2;

use Wsers2;

CREATE TABLE Countries (
    CountryID int unique not null AUTO_INCREMENT,
    CountryName varchar(255) unique,
    PRIMARY KEY (CountryID)
);

create table Cities(
    CityId int unique not null AUTO_INCREMENT,
    CityName varchar(255) unique,
    Inhabitants int not null,
    PRIMARY KEY (CityId),
    CountryID int not null,
    FOREIGN KEY (CountryID) REFERENCES Countries(CountryID)
);

insert into Countries(CountryName) VALUES("Germany");
insert into Countries(CountryName) VALUES("France");
insert into Countries(CountryName) VALUES("Romania");
insert into Countries(CountryName) VALUES("UK");


insert into Cities(CityName,CountryID,Inhabitants) VALUES("Dusseldorf",1,200000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Hambourg",1,250000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Berlin",1,1000000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Trier",1,100000);

insert into Cities(CityName,CountryID,Inhabitants) VALUES("Paris",2,5000000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Dijon",2,400000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Nice",2,600000);

insert into Cities(CityName,CountryID,Inhabitants) VALUES("Bucharest",3,1000000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Cluj-Napoca",3,325000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Iasi",3,120000);

insert into Cities(CityName,CountryID,Inhabitants) VALUES("London",4,15000000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("York",4,50000);
insert into Cities(CityName,CountryID,Inhabitants) VALUES("Birmingham",4,60000);
