--
-- Structure for table 'groups' - v2.7+ (optional)
--
CREATE TABLE `group_list` (
  `group_id` int(9) unsigned NOT NULL auto_increment,
  `group_name` varchar(255) NOT NULL default '',
  `group_header` mediumtext NOT NULL,
  PRIMARY KEY  (`group_id`)
);

-- 
-- Structure for table `address_in_groups` - v2.7+ (optional)
-- 
CREATE TABLE `address_in_groups` (
  `id` int(9) unsigned NOT NULL default '0',
  `group_id` int(9) unsigned NOT NULL default '0',
  PRIMARY KEY  (`group_id`,`id`)
);


-- 
-- Test group "Rob" (For: Rob M., Autor of version 1.2).
-- 
INSERT INTO `group_list` (group_name, group_header) VALUES ('Rob', '<td>\r\n   <font size=+1><b><center>Rob</center><hr><i>Thanks!</i></b></font>\r\n</td>');
