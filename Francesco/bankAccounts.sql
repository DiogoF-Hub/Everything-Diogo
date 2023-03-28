DROP DATABASE bankAccounts;
create database bankAccounts;

use bankAccounts;

create table ppl(
    PersonId int unique not null AUTO_INCREMENT,
    PersonName varchar(50) unique,
    Balance int,
    PRIMARY KEY (PersonId)
);

Insert into ppl(PersonName,Balance) Values("John",5000);
Insert into ppl(PersonName,Balance) Values("Noa",10000);
Insert into ppl(PersonName,Balance) Values("Sven",200);
Insert into ppl(PersonName,Balance) Values("Dan",250);
Insert into ppl(PersonName,Balance) Values("Nora",550);
Insert into ppl(PersonName,Balance) Values("Sam",2500);
Insert into ppl(PersonName,Balance) Values("Tristan",350);
Insert into ppl(PersonName,Balance) Values("Joe",800);
Insert into ppl(PersonName,Balance) Values("User",1200);
