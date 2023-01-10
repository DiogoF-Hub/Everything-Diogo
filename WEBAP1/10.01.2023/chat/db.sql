drop database Chat;
create database Chat;

use Chat;

create table Users(
    UserId int unique not null AUTO_INCREMENT,
    UserName varchar(50) unique,
    PRIMARY KEY (UserId)
    );

CREATE TABLE Messages (
    MsgId int unique not null AUTO_INCREMENT,
    UserId int,
    MsgText varchar(255),
    FOREIGN KEY (UserId) references Users(UserId),
    PRIMARY KEY (MsgId)
);


