DROP DATABASE Shop;
CREATE DATABASE Shop;

use Shop;

CREATE TABLE Users(
    UserId INT NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(30) UNIQUE,
    PRIMARY KEY (UserId)
);

CREATE TABLE Products(
    ProductId INT NOT NULL AUTO_INCREMENT,
    ProductName VARCHAR(50),
    ProductDesc VARCHAR(100),
    ProductPrice INT,
    PRIMARY KEY (ProductId)
);

INSERT INTO Users(UserName) VALUES("Dan");
INSERT INTO Users(UserName) VALUES("Francesco");
INSERT INTO Users(UserName) VALUES("Vlad");

INSERT INTO Products(ProductName, ProductDesc, ProductPrice) VALUES("Tomatoes", "They are good for your health", 200);
INSERT INTO Products(ProductName, ProductDesc, ProductPrice) VALUES("Potatoes", "Only for poor people", 2);
INSERT INTO Products(ProductName, ProductDesc, ProductPrice) VALUES("Cars", "This is to show off", 20000);