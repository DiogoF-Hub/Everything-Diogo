create database Users;
use Users;

create table Users(
UserId int not NULL AUTO_INCREMENT,
UserName VARCHAR(30) UNIQUE,
UserPassword varchar(255),
PRIMARY KEY (UserId)
);

insert into Users(UserName,UserPassword) VALUES("John","123");
insert into Users(UserName,UserPassword) VALUES("Angelina","000");
insert into Users(UserName,UserPassword) VALUES("Peppa","111");