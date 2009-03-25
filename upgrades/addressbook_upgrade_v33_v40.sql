--
-- Upgrade from 3.3/3.4 to 4.0
--
-- Included database extensions:
-- * Notes field
-- * User login capability
-- * User preferences storage capability
-- * Change logging capability
--
-- The features inside the .php code will 
-- follow later step-by-step.
--


--
-- "Notes" field
--
ALTER TABLE `addressbook` ADD `notes`    mediumtext     NULL after phone2;
--
-- Authentication / Autorisation
--
ALTER TABLE `addressbook` ADD `password` VARCHAR( 256 ) NULL after modified;
ALTER TABLE `addressbook` ADD `login`    DATE           NULL after `password`;
ALTER TABLE `addressbook` ADD `role`     VARCHAR( 256 ) NULL after login;
--
-- Timestamps
--
ALTER TABLE `addressbook` ADD `created`  DATETIME       NULL after `notes`;
ALTER TABLE `addressbook` ADD `modified` DATETIME       NULL after `created` ;

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
CREATE TABLE IF NOT EXISTS `addr_user_prefs` (
  `id` int(9) unsigned NOT NULL,
  `pref_key`   varchar(255) NOT NULL default '',
  `pref_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`,`pref_key`),
  KEY `fk_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

/*
--
-- Change the engine to support transactions & constraints
--
alter table addr_addressbook       ENGINE=InnoDB;
alter table addr_address_in_groups ENGINE=InnoDB;
alter table addr_group_list        ENGINE=InnoDB;
alter table addr_month_lookup      ENGINE=InnoDB;


--
-- Constraints for better integrity
--
ALTER TABLE addr_address_in_groups
  ADD FOREIGN KEY fk_id (id)
      REFERENCES addr_addressbook;
--
ALTER TABLE addr_address_in_groups
  ADD FOREIGN KEY fk_group_id (group_id)
      REFERENCES addr_group_list;
*/