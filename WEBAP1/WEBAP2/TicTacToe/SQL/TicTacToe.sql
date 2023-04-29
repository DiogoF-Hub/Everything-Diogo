DROP DATABASE TicTacToe;
CREATE DATABASE TicTacToe;
USE TicTacToe;

CREATE TABLE Users(
    userName VARCHAR(15) PRIMARY KEY,
    email_id VARCHAR(255) NOT NULL UNIQUE,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    userpassword VARCHAR(255) NOT NULL
);


INSERT INTO Users (userName, email_id, firstname, lastname, userpassword) VALUES("Lil", "bla@gmail.com", "Diogo", "Fernandes", "$2y$10$y9Dttj64zc1pEIVx2.sszuKVpZylgFECOMRdwxk0fehq1DOzkwQXi");