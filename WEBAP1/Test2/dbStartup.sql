create or replace database examCities;
use examCities;

create table Cities(
    cityName varchar(255) not null unique primary key
);