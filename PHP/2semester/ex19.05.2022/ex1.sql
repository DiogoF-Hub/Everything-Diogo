DROP DATABASE countries;
CREATE DATABASE countries;
USE countries;

CREATE TABLE countriesTable(
    id INT NOT NULL AUTO_INCREMENT,
    countriesName VARCHAR(255),
    PRIMARY KEY(id)
);


INSERT INTO countriesTable (countriesName) VALUES("Portugal");

INSERT INTO countriesTable (countriesName) VALUES("Spain");

INSERT INTO countriesTable (countriesName) VALUES("USA");

INSERT INTO countriesTable (countriesName) VALUES("France");