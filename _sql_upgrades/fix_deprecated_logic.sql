-- Upgrade script to fix "deprecated" column filtering logic
-- This script adds surrogate primary keys to allow the "deprecated" column to be nullable.

-- addressbook table
ALTER TABLE `addressbook` DROP PRIMARY KEY;
ALTER TABLE `addressbook` ADD `pid` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE `addressbook` MODIFY `deprecated` DATETIME DEFAULT NULL;
ALTER TABLE `addressbook` ADD INDEX `id_deprecated_domain_id_idx` (`id`, `deprecated`, `domain_id`);
UPDATE `addressbook` SET `deprecated` = NULL WHERE `deprecated` = '1000-01-01 00:00:00' OR `deprecated` = '0000-00-00 00:00:00';

-- group_list table
ALTER TABLE `group_list` DROP PRIMARY KEY;
ALTER TABLE `group_list` ADD PRIMARY KEY (`group_id`);
ALTER TABLE `group_list` MODIFY `deprecated` DATETIME DEFAULT NULL;
UPDATE `group_list` SET `deprecated` = NULL WHERE `deprecated` = '1000-01-01 00:00:00' OR `deprecated` = '0000-00-00 00:00:00';

-- address_in_groups table
ALTER TABLE `address_in_groups` DROP PRIMARY KEY;
ALTER TABLE `address_in_groups` ADD `ag_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE `address_in_groups` MODIFY `deprecated` DATETIME DEFAULT NULL;
ALTER TABLE `address_in_groups` ADD INDEX `group_id_id_deprecated_idx` (`group_id`, `id`, `deprecated`);
UPDATE `address_in_groups` SET `deprecated` = NULL WHERE `deprecated` = '1000-01-01 00:00:00' OR `deprecated` = '0000-00-00 00:00:00';

-- users table
ALTER TABLE `users` MODIFY `deprecated` DATETIME DEFAULT NULL;
UPDATE `users` SET `deprecated` = NULL WHERE `deprecated` = '1000-01-01 00:00:00' OR `deprecated` = '0000-00-00 00:00:00';
