drop database promos;
create database promos;
use promos;

create table PPL(
    idPerson int not null AUTO_INCREMENT,
    UsrName varchar(20) UNIQUE,
    Money int,
    primary key (idPerson)
);

create table promoTable(
    idPromo int not null AUTO_INCREMENT,
    KeyWord varchar(20) UNIQUE,
    Amount int,
    Available int,
    primary key (idPromo)
);


insert into promoTable(KeyWord,Amount,Available) Values("Promo1",20,5);
insert into promoTable(KeyWord,Amount,Available) Values("Promo2",50,2);
insert into promoTable(KeyWord,Amount,Available) Values("PromoXXX",200,1);
