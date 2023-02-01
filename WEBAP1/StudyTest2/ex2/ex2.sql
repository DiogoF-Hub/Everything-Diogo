DROP DATABASE ex2DataBase;
create database ex2DataBase;
use ex2DataBase;

CREATE TABLE `TableSaves`(
    `TableSaves_id` INT AUTO_INCREMENT PRIMARY KEY,
    `TableArr` VARCHAR(65536) NOT NULL
);