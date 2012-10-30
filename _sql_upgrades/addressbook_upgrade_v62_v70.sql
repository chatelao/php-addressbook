--
-- Upgrade from 6.2.x to 7.0.x
--

--
-- Add anniversary-fields (aday, amonth, ayear), email3, im, im2, im3, x_activesync
--
ALTER TABLE `addressbook` ADD `nickname` varchar(255) default NULL AFTER `lastname`;
ALTER TABLE `addressbook` ADD `company`  varchar(255) default NULL AFTER `nickname`;
ALTER TABLE `addressbook` ADD `title`    varchar(255) default NULL AFTER `company`;

ALTER TABLE `addressbook` ADD `aday`   tinyint(2)   default NULL   AFTER `byear`;
ALTER TABLE `addressbook` ADD `amonth` varchar(50)  default NULL   AFTER `aday`;
ALTER TABLE `addressbook` ADD `ayear`  varchar(4)   default NULL   AFTER `amonth`;
                                                                   
ALTER TABLE `addressbook` ADD `email3` text         default NULL   AFTER `email2`;
                                                                   
ALTER TABLE `addressbook` ADD `im`  text            default NULL   AFTER `email3`;
ALTER TABLE `addressbook` ADD `im2` text            default NULL   AFTER `im`;
ALTER TABLE `addressbook` ADD `im3` text            default NULL   AFTER `im2`;

ALTER TABLE `addressbook` DROP PRIMARY KEY;
ALTER TABLE `addressbook` ADD PRIMARY KEY (id,deprecated,domain_id);
