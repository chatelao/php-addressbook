--
-- Upgrade from 6.1.x to 6.2.x
--

--
-- Add long, lat, photo and vcard column
--
ALTER TABLE `addressbook` ADD `addr_long`   text   default NULL AFTER `address`;
ALTER TABLE `addressbook` ADD `addr_lat`    text   default NULL AFTER `addr_long`;
ALTER TABLE `addressbook` ADD `addr_status` text   default NULL AFTER `addr_lat`;
ALTER TABLE `addressbook` ADD `photo`   mediumtext default NULL AFTER `notes`;
ALTER TABLE `addressbook` ADD `x_vcard` mediumtext default NULL AFTER `photo`;
