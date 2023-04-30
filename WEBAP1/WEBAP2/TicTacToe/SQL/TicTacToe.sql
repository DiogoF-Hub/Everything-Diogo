DROP DATABASE TicTacToe;
CREATE DATABASE TicTacToe;
USE TicTacToe;

CREATE TABLE Users(
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(15) UNIQUE,
    email_id VARCHAR(320) NOT NULL UNIQUE,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    userpassword VARCHAR(255) NOT NULL
);

INSERT INTO Users (userName, email_id, firstname, lastname, userpassword) VALUES("Lil", "bla@gmail.com", "Diogo", "Fernandes", "$2y$10$y9Dttj64zc1pEIVx2.sszuKVpZylgFECOMRdwxk0fehq1DOzkwQXi");


CREATE TABLE Games(
    GameID INT AUTO_INCREMENT PRIMARY KEY,
    FirstPlayerID VARCHAR(320),
    SecondPlayerID VARCHAR(320),
    GameStatus INT(1)
);


CREATE TABLE Moves(
    GameID INT,
    Player VARCHAR(320),
    Place INT(1)
);


ALTER TABLE
    `Moves` ADD CONSTRAINT `Games_GameID_foreign` FOREIGN KEY(`GameID`) REFERENCES `Games`(`GameID`);