--
-- Upgrade from 5.0 to 6.0
--
-- Included database extensions:
-- * Domain ids for multiple customer on the same DB.
-- * Deprecaction date for "remebered" deletion / alternation.
--
-- The code to implement this features will follow sonner or later.
--

--
-- Add "domain_id" field, to separate more than one domain.
--
ALTER TABLE `addressbook`       ADD `domain_id` int(9) unsigned NOT NULL default 0 FIRST;
ALTER TABLE `group_list`        ADD `domain_id` int(9) unsigned NOT NULL default 0 FIRST;
ALTER TABLE `address_in_groups` ADD `domain_id` int(9) unsigned NOT NULL default 0 FIRST;
ALTER TABLE `user_prefs`        ADD `domain_id` int(9) unsigned NOT NULL default 0 FIRST;

--
-- Add "deprecated" field, to enable deletion recovery and timeline handling.
--
ALTER TABLE `addressbook`       ADD `deprecated` datetime default NULL AFTER `modified`;
ALTER TABLE `group_list`        ADD `deprecated` datetime default NULL AFTER `modified`;
ALTER TABLE `address_in_groups` ADD `deprecated` datetime default NULL AFTER `modified`;
ALTER TABLE `user_prefs`        ADD `deprecated` datetime default NULL AFTER `modified`;

