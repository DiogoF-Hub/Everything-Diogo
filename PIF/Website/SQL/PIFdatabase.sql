DROP DATABASE PIFDatabase;
create database PIFDatabase;
use PIFDatabase;


CREATE TABLE `Groups_permissions`(
    `group_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `admin` INT NOT NULL,
    `schedule` INT NOT NULL,
    `view_sensitive_data` INT NOT NULL,
    `open_door_available` INT NOT NULL
);

INSERT INTO `Groups_permissions` (`name`, `admin`, `schedule`, `view_sensitive_data`, `open_door_available`) VALUES ('NewUser', 0, 0, 0, 0);
INSERT INTO `Groups_permissions` (`name`, `admin`, `schedule`, `view_sensitive_data`, `open_door_available`) VALUES ('Admin', 1, 1, 1, 1);
INSERT INTO `Groups_permissions` (`name`, `admin`, `schedule`, `view_sensitive_data`, `open_door_available`) VALUES ('Employee', 0, 1, 1, 1);



CREATE TABLE `Users`(
    `user_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `email_id` VARCHAR(255) NOT NULL UNIQUE,
    `Userpassword` VARCHAR(255) NOT NULL,
    `batch_number_id` INT NOT NULL UNIQUE,
    `phoneNumber` VARCHAR(16) UNIQUE,
    `profilePic` INT NOT NULL,
    `group_id` INT NOT NULL,
    `verified_email` INT NOT NULL,
    `verified_email_code` VARCHAR(255) NOT NULL
);

INSERT INTO `Users` (`firstname`, `lastname`, `email_id`, `Userpassword`, `batch_number_id`, `group_id`, `phoneNumber`, `profilePic`) VALUES ("Diogo", "Fernandes", "bla@gmail.com", "$2y$10$y9Dttj64zc1pEIVx2.sszuKVpZylgFECOMRdwxk0fehq1DOzkwQXi", 2, 2, "+352661650012", 0);

CREATE TABLE `Rooms`(
    `room_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `number` VARCHAR(255) NOT NULL,
    `capacity` INT NOT NULL,
    `description` TEXT NOT NULL
);
INSERT INTO `Rooms` (`number`, `capacity`, `description`) VALUES ("A22", 20, "This is the room A22");

CREATE TABLE `Booking_info`(
    `room_id` INT NOT NULL,
    `email_id` VARCHAR(255) NOT NULL,
    `booking_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `date` DATE NOT NULL,
    `purpose` VARCHAR(255) NOT NULL
);


CREATE TABLE `Schedule_Slots`(
    `schedule_slot_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `start_time` INT NOT NULL,
    `end_time` INT NOT NULL
);


CREATE TABLE `Batches`(
    `batch_number_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `key` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO `Batches` (`key`) VALUES ("sdgser3446");
INSERT INTO `Batches` (`key`) VALUES ("sdvfedr5656");
INSERT INTO `Batches` (`key`) VALUES ("sdkfjerj4748");


CREATE TABLE `Booking_list`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `booking_id` INT,
    `schedule_slot_id` INT NOT NULL
);


ALTER TABLE
    `Users` ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY(`group_id`) REFERENCES `Groups_permissions`(`group_id`);
ALTER TABLE
    `Booking_info` ADD CONSTRAINT `booking_info_email_id_foreign` FOREIGN KEY(`email_id`) REFERENCES `Users`(`email_id`);
ALTER TABLE
    `Booking_info` ADD CONSTRAINT `booking_info_room_id_foreign` FOREIGN KEY(`room_id`) REFERENCES `Rooms`(`room_id`);
ALTER TABLE
    `Booking_list` ADD CONSTRAINT `booking_list_booking_id_foreign` FOREIGN KEY(`booking_id`) REFERENCES `Booking_info`(`booking_id`);
ALTER TABLE
    `Booking_list` ADD CONSTRAINT `booking_list_schedule_slot_id_foreign` FOREIGN KEY(`schedule_slot_id`) REFERENCES `Schedule_Slots`(`schedule_slot_id`);
ALTER TABLE
    `Users` ADD CONSTRAINT `users_batch_number_id_foreign` FOREIGN KEY(`batch_number_id`) REFERENCES `Batches`(`batch_number_id`);


INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '8', '9');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '9', '10');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '10', '11');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '11', '12');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '12', '13');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '13', '14');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '14', '15');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '15', '16');
INSERT INTO `Schedule_Slots` (`schedule_slot_id`, `start_time`, `end_time`) VALUES (NULL, '16', '17');




/*Create View*/
CREATE VIEW AvailableBatches AS SELECT * FROM Batches WHERE batch_number_id NOT IN(SELECT batch_number_id FROM Users);




