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
-- "domain_id" field, to separate more than one domain.
--
ALTER TABLE `addressbook`       DROP COLUMN `domain_id`;
ALTER TABLE `group_list`        DROP COLUMN `domain_id`;
ALTER TABLE `address_in_groups` DROP COLUMN `domain_id`;
ALTER TABLE `user_prefs`        DROP COLUMN `domain_id`;

--
-- "deprected" field, to allow recovery enable deletion and timeline handling.
--
ALTER TABLE `addressbook`       DROP COLUMN `deprecated`;
ALTER TABLE `group_list`        DROP COLUMN `deprecated`;
ALTER TABLE `address_in_groups` DROP COLUMN `deprecated`;
ALTER TABLE `user_prefs`        DROP COLUMN `deprecated`;
