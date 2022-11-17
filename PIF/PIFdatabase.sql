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


CREATE TABLE `Users`(
    `name` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
    `email_id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `password` VARCHAR(255) NOT NULL,
    `batch_number_id` INT NOT NULL UNIQUE,
    `group_id` INT NOT NULL,
    `verified_email` INT NOT NULL
);


CREATE TABLE `Rooms`(
    `room_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `number` VARCHAR(255) NOT NULL,
    `capacity` INT NOT NULL,
    `description` TEXT NOT NULL
);


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
    `key` INT NOT NULL
);


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