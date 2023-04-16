DROP DATABASE TicTacToeDatabase;
CREATE DATABASE TicTacToeDatabase;
USE TicTacToeDatabase;

CREATE TABLE Users(
    userName VARCHAR(25) PRIMARY KEY,
    email_id VARCHAR(255) NOT NULL UNIQUE,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    userpassword VARCHAR(255) NOT NULL
);


INSERT INTO Users ( userName, email_id, firstname, lastname, userpassword ) VALUES("Lil", "bla@gmail.com", "Diogo", "Fernandes", "123456");