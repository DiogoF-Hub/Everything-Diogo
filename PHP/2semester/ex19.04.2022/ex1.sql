drop database Shop;
create database Shop;
use Shop;

create TABLE Users(
    UserID INT NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(30) UNIQUE,
    UserPassword VARCHAR(255),
    Primary Key(UserID)
);