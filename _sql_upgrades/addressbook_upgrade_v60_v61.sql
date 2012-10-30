--
-- Upgrade from 6.0 to 6.1
--

--
-- Change the primary key, to enable the timeline handling.
--
ALTER TABLE `addressbook` CHANGE `id` `id` INT( 9 ) UNSIGNED NOT NULL;
ALTER TABLE `addressbook` DROP PRIMARY KEY;
ALTER TABLE `addressbook` ADD PRIMARY KEY ( `id` , `deprecated` );

ALTER TABLE `address_in_groups` DROP PRIMARY KEY;
ALTER TABLE `address_in_groups` ADD PRIMARY KEY ( `group_id`, `id`, `deprecated` );
