DROP DATABASE PIFDatabase;
create database PIFDatabase;
use PIFDatabase;


CREATE TABLE `Groups_permissions`(
    `group_id` INT AUTO_INCREMENT PRIMARY KEY,
    `group_name` VARCHAR(255) NOT NULL,
    `admin` INT NOT NULL,
    `schedule` INT NOT NULL,
    `view_schedule` INT NOT NULL,
    `view_sensitive_data` INT NOT NULL,
    `open_door_any_time` INT NOT NULL,
    `open_door_available` INT NOT NULL
);

INSERT INTO `Groups_permissions` (`group_name`, `admin`, `schedule`, `view_schedule`, `view_sensitive_data`, `open_door_any_time`, `open_door_available`) VALUES ('New User', 0, 0, 0, 0, 0, 0);
INSERT INTO `Groups_permissions` (`group_name`, `admin`, `schedule`, `view_schedule`, `view_sensitive_data`, `open_door_any_time`, `open_door_available`) VALUES ('Admin', 1, 1, 1, 1, 1, 1);
INSERT INTO `Groups_permissions` (`group_name`, `admin`, `schedule`, `view_schedule`, `view_sensitive_data`, `open_door_any_time`, `open_door_available`) VALUES ('Employee', 0, 1, 1, 1, 0, 1);
INSERT INTO `Groups_permissions` (`group_name`, `admin`, `schedule`, `view_schedule`, `view_sensitive_data`, `open_door_any_time`, `open_door_available`) VALUES ('Cleaning Staff', 0, 0, 1, 0, 0, 1);



CREATE TABLE `Users`(
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `email_id` VARCHAR(255) NOT NULL UNIQUE,
    `Userpassword` VARCHAR(255) NOT NULL,
    `batch_number_id` INT NOT NULL UNIQUE,
    `group_id` INT NOT NULL
);

INSERT INTO `Users` (`firstname`, `lastname`, `email_id`, `Userpassword`, `batch_number_id`, `group_id`) VALUES ("Diogo", "Fernandes", "bla@gmail.com", "$2y$10$y9Dttj64zc1pEIVx2.sszuKVpZylgFECOMRdwxk0fehq1DOzkwQXi", 2, 2);

CREATE TABLE `Rooms`(
    `room_id` INT AUTO_INCREMENT PRIMARY KEY,
    `number` VARCHAR(255) NOT NULL,
    `capacity` INT NOT NULL,
    `description` TEXT NOT NULL
);

INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A01", 20, "This is the room A01");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A02", 25, "This is the room A02");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A03", 24, "This is the room A03");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A04", 19, "This is the room A04");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A05", 13, "This is the room A05");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A06", 45, "This is the room A06");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A07", 56, "This is the room A07");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A08", 16, "This is the room A08");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A09", 32, "This is the room A09");
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A10", 23, "This is the room A10");


CREATE TABLE `Booking_info`(
    `booking_id` INT AUTO_INCREMENT PRIMARY KEY,
    `room_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `booking_date` DATE NOT NULL,
    `purpose` VARCHAR(255) NOT NULL,
    `start_time` INT NOT NULL,
    `end_time` INT NOT NULL
);


CREATE TABLE `Batches`(
    `batch_number_id` INT AUTO_INCREMENT PRIMARY KEY,
    `badge_key` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO `Batches` (`badge_key`) VALUES ("sdgser3446");
INSERT INTO `Batches` (`badge_key`) VALUES ("sdvfedr5656");
INSERT INTO `Batches` (`badge_key`) VALUES ("sdkfjerj4748");
INSERT INTO `Batches` (`badge_key`) VALUES ("kfjergrj4748");
INSERT INTO `Batches` (`badge_key`) VALUES ("kfjeferj4748");
INSERT INTO `Batches` (`badge_key`) VALUES ("fgesjerj4748");



ALTER TABLE
    `Users` ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY(`group_id`) REFERENCES `Groups_permissions`(`group_id`);
ALTER TABLE
    `Booking_info` ADD CONSTRAINT `booking_info_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `Users`(`user_id`);
ALTER TABLE
    `Booking_info` ADD CONSTRAINT `booking_info_room_id_foreign` FOREIGN KEY(`room_id`) REFERENCES `Rooms`(`room_id`);
ALTER TABLE
    `Users` ADD CONSTRAINT `users_batch_number_id_foreign` FOREIGN KEY(`batch_number_id`) REFERENCES `Batches`(`batch_number_id`);


/*Create View*/
CREATE VIEW AvailableBatches AS SELECT * FROM Batches WHERE batch_number_id NOT IN(SELECT batch_number_id FROM Users) ORDER BY batch_number_id;

CREATE VIEW UserEditProfileJoin AS SELECT user_id, firstname, lastname, email_id, Userpassword, batch_number_id, group_name FROM Users NATURAL JOIN Groups_permissions;
