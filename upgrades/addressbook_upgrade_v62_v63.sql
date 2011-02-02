--
-- Upgrade from 6.2.x to 6.3.x
--

--
-- Add anniversary-fields (aday, amonth, ayear), email3, im, im2, im3, x_activesync
--
ALTER TABLE `addr_addressbook` ADD `aday`   tinyint(2)   default NULL AFTER `byear`;
ALTER TABLE `addr_addressbook` ADD `amonth` varchar(50)  default NULL AFTER `aday`;
ALTER TABLE `addr_addressbook` ADD `ayear`  varchar(4)   default NULL AFTER `amonth`;

ALTER TABLE `addr_addressbook` ADD `email3` text         default NULL AFTER `email2`;

ALTER TABLE `addr_addressbook` ADD `im`  text            default NULL AFTER `email3`;
ALTER TABLE `addr_addressbook` ADD `im2` text            default NULL AFTER `im`;
ALTER TABLE `addr_addressbook` ADD `im3` text            default NULL AFTER `im2`;

ALTER TABLE `addr_addressbook` ADD `x_activesync` text   default NULL AFTER `x_vcard`;
