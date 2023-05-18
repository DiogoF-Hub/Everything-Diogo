DROP DATABASE DatabasePIF;
CREATE DATABASE DatabasePIF;
USE DatabasePIF;


CREATE TABLE `Groups_Permissions`(
    `group_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `group_name` VARCHAR(255) NOT NULL,
    `admin` INT NOT NULL,
    `open_doors_when_free` INT NOT NULL,
    `make_reservations` INT NOT NULL,
    `view_sensitive_data` INT NOT NULL
);

INSERT INTO  `Groups_Permissions` (`group_name`, `admin`, `open_doors_when_free`, `make_reservations`, `view_sensitive_data` ) VALUES("Admin", 1,1,1,1);
INSERT INTO  `Groups_Permissions` (`group_name`, `admin`, `open_doors_when_free`, `make_reservations`, `view_sensitive_data` ) VALUES("Employe", 0,0,1,0);


CREATE TABLE `Users`(
    `user_email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `group_id` INT NOT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `RFIDBadge_id` INT NOT NULL
);

INSERT INTO  `Users` (`user_email`, `group_id`, `firstname`,  `surname`, `user_password`, `RFIDBadge_id`) VALUES("rui@gmail.com", 1, "Rui", "Fidelis", "$2y$10$Ao7zcJ6sBaIf8vBGuFWz2eAbEAa1UKiaCoHIOzxfVeTA7SzBxmqRW", 1);
INSERT INTO  `Users` (`user_email`, `group_id`, `firstname`,  `surname`, `user_password`, `RFIDBadge_id`) VALUES("rui2@gmail.com", 2, "Rui2", "Fidelis2", "$2y$10$Ao7zcJ6sBaIf8vBGuFWz2eAbEAa1UKiaCoHIOzxfVeTA7SzBxmqRW", 2);

CREATE TABLE `Rooms`(
    `room_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `numroom` VARCHAR(255) NOT NULL
);


INSERT INTO `Rooms` (`room_id`, `numroom`) VALUES (NULL, "A11");
INSERT INTO `Rooms` (`room_id`, `numroom`) VALUES (NULL, "A12");
INSERT INTO `Rooms` (`room_id`, `numroom`) VALUES (NULL, "A13");
INSERT INTO `Rooms` (`room_id`, `numroom`) VALUES (NULL, "A14");

CREATE TABLE `Reserve_Details`(
    `reservation_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `purpose` VARCHAR(255) NOT NULL,
    `room_id` INT NOT NULL,
    `date` DATE NOT NULL,
    `user_email` VARCHAR(255) NOT NULL,
    `start_time` INT NOT NULL,
    `end_time` INT NOT NULL
);


CREATE TABLE `Badges`(
    `RFIDBadge_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `keyID` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO  `Badges` (`keyID`) VALUES("1111");
INSERT INTO  `Badges` (`keyID`) VALUES("2222");
INSERT INTO  `Badges` (`keyID`) VALUES("3333");
INSERT INTO  `Badges` (`keyID`) VALUES("4444");


ALTER TABLE
    `Users` ADD CONSTRAINT `user_group_id_foreign` FOREIGN KEY(`group_id`) REFERENCES `Groups_Permissions`(`group_id`);
ALTER TABLE
    `Reserve_Details` ADD CONSTRAINT `reserve_details_user_email_foreign` FOREIGN KEY(`user_email`) REFERENCES `Users`(`user_email`);
ALTER TABLE
    `Reserve_Details` ADD CONSTRAINT `reserve_details_room_id_foreign` FOREIGN KEY(`room_id`) REFERENCES `Rooms`(`room_id`);
ALTER TABLE
    `Users` add CONSTRAINT `users_rfidbadge_id_foreign` FOREIGN KEY(`RFIDBadge_id`) REFERENCES `Badges`(`RFIDBadge_id`);





CREATE VIEW BadgesNotTaken AS SELECT * FROM Badges WHERE RFIDBadge_id NOT IN(SELECT RFIDBadge_id FROM Users) ORDER BY RFIDBadge_id;

CREATE VIEW UsersInfo AS SELECT user_email, group_name, firstname, surname, RFIDBadge_id  FROM Users NATURAL JOIN Groups_Permissions;
