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

INSERT INTO  `Groups_Permissions` (`group_name`, `admin`, `open_doors_when_free`, `make_reservations`, `view_sensitive_data` ) VALUES("NewUser", 0,0,0,0);
INSERT INTO  `Groups_Permissions` (`group_name`, `admin`, `open_doors_when_free`, `make_reservations`, `view_sensitive_data` ) VALUES("Admin", 1,1,1,1);

CREATE TABLE `Users`(
    `user_email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `group_id` INT NOT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `RFIDBadge_id` INT NOT NULL
);

INSERT INTO  `Users` (`user_email`, `group_id`, `firstname`,  `surname`, `user_password`, `RFIDBadge_id`) VALUES("rui@gmail.com", 2, "Rui", "Fidelis", "$2y$10$Ao7zcJ6sBaIf8vBGuFWz2eAbEAa1UKiaCoHIOzxfVeTA7SzBxmqRW", 1);
INSERT INTO  `Users` (`user_email`, `group_id`, `firstname`,  `surname`, `user_password`, `RFIDBadge_id`) VALUES("rui2@gmail.com", 1, "Rui2", "Fidelis2", "$2y$10$Ao7zcJ6sBaIf8vBGuFWz2eAbEAa1UKiaCoHIOzxfVeTA7SzBxmqRW", 3);

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
    `user_email` VARCHAR(255) NOT NULL
);

CREATE TABLE `Reserved_Hour`(
    `reserve_time_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `start_time` INT NOT NULL,
    `end_time` INT NOT NULL
);

INSERT INTO `Reserved_Hour` (`reserve_time_id`, `start_time`, `end_time`) VALUES
(NULL, "08:00", "09:00"),
(NULL, "09:00", "10:00"),
(NULL, "10:00", "11:00"),
(NULL, "11:00", "12:00"),
(NULL, "12:00", "13:00"),
(NULL, "13:00", "14:00"),
(NULL, "14:00", "15:00"),
(NULL, "15:00", "16:00"),
(NULL, "16:00", "17:00");

CREATE TABLE `Badges`(
    `RFIDBadge_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO  `Badges` (`key`) VALUES("drrthwef");
INSERT INTO  `Badges` (`key`) VALUES("sdrbtzkwG");
INSERT INTO  `Badges` (`key`) VALUES("WEGRZJMTZ");
INSERT INTO  `Badges` (`key`) VALUES("ergtzrzk");


CREATE TABLE `Reserve_List`(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `reservation_id` INT NOT NULL,
    `reserve_time_id` INT NOT NULL
);

ALTER TABLE
    `Users` ADD CONSTRAINT `user_group_id_foreign` FOREIGN KEY(`group_id`) REFERENCES `Groups_Permissions`(`group_id`);
ALTER TABLE
    `Reserve_Details` ADD CONSTRAINT `reserve_details_user_email_foreign` FOREIGN KEY(`user_email`) REFERENCES `Users`(`user_email`);
ALTER TABLE
    `Reserve_Details` ADD CONSTRAINT `reserve_details_room_id_foreign` FOREIGN KEY(`room_id`) REFERENCES `Rooms`(`room_id`);
ALTER TABLE
    `Reserve_List` add CONSTRAINT `reserve_list_reservation_id_foreign` FOREIGN KEY(`reservation_id`) REFERENCES `Reserve_Details`(`reservation_id`);
ALTER TABLE
    `Reserve_List` add CONSTRAINT `reserve_list_reserve_time_id_foreign` FOREIGN KEY(`reserve_time_id`) REFERENCES `reserved_Hour`(`reserve_time_id`);
ALTER TABLE
    `Users` add CONSTRAINT `users_rfidbadge_id_foreign` FOREIGN KEY(`RFIDBadge_id`) REFERENCES `Badges`(`RFIDBadge_id`);





CREATE VIEW BadgesNotTaken AS SELECT * FROM Badges WHERE RFIDBadge_id NOT IN(SELECT RFIDBadge_id FROM Users) ORDER BY RFIDBadge_id;

CREATE VIEW UsersInfo AS SELECT user_email, group_name, firstname, surname, RFIDBadge_id  FROM Users NATURAL JOIN Groups_Permissions;
