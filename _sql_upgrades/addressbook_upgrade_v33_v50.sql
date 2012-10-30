--
-- Upgrade from 3.3/3.4 to 5.0
--
-- Included database extensions:
-- * Notes, company, homepage fields
-- * User login capability
-- * User preferences storage capability
-- * Change logging capability
--
-- The features inside the .php code will 
-- follow later step-by-step.
--

--
-- "Company" field
--
ALTER TABLE `addressbook` ADD `company`  varchar(255)   NULL after lastname;
--
-- "Fax" field
--
ALTER TABLE `addressbook` ADD `fax`      text           NULL after work;
--
-- "Homepage" field
--
ALTER TABLE `addressbook` ADD `homepage` text           NULL after email2;
--
-- "Notes" field
--
ALTER TABLE `addressbook` ADD `notes`    mediumtext     NULL after phone2;
--
-- Timestamps
--
ALTER TABLE `addressbook` ADD `created`  DATETIME       NULL after `notes`;
ALTER TABLE `addressbook` ADD `modified` DATETIME       NULL after `created` ;
--
-- Authentication / Autorisation
--
ALTER TABLE `addressbook` ADD `password` VARCHAR( 256 ) NULL after modified;
ALTER TABLE `addressbook` ADD `login`    DATE           NULL after `password`;
ALTER TABLE `addressbook` ADD `role`     VARCHAR( 256 ) NULL after login;

--
-- Timestamps
--
ALTER TABLE `group_list`  ADD `created`  DATETIME            NULL after `group_parent_id`;
ALTER TABLE `group_list`  ADD `modified` DATETIME            NULL after `created` ;

--
-- Timestamps
--
ALTER TABLE `address_in_groups`  ADD `created` DATETIME     NULL after `group_id`;
ALTER TABLE `address_in_groups`  ADD `deleted` DATETIME     NULL after `created` ;

--
-- Table for user preferences
--
CREATE TABLE IF NOT EXISTS `user_prefs` (
  `id` int(9) unsigned NOT NULL,
  `pref_key`   varchar(255) NOT NULL default '',
  `pref_value` varchar(255) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`,`pref_key`),
  KEY `fk_id` (`id`)
) DEFAULT CHARSET=utf8;
