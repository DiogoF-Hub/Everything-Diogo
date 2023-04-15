DROP DATABASE TicTacToeDatabase;
CREATE DATABASE TicTacToeDatabase;
USE TicTacToeDatabase;

CREATE TABLE Users(
    userName VARCHAR(25) PRIMARY KEY,
    email_id VARCHAR(255) NOT NULL UNIQUE,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    Userpassword VARCHAR(255) NOT NULL
);