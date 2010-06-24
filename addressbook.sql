--
-- Creation script with sample data for "php-addressbook"
--
-- * You may add table prefixes, if the "$table_prefix"
--   parameter is set in "config.php".
--

CREATE TABLE addressbook (
  domain_id int(9) unsigned NOT NULL default '0',
  id int(9) unsigned NOT NULL auto_increment,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  company varchar(255) NOT NULL,
  address text NOT NULL,
  home text NOT NULL,
  mobile text NOT NULL,
  work text NOT NULL,
  fax text NOT NULL,
  email text NOT NULL,
  email2 text NOT NULL,
  homepage text NOT NULL,
  bday tinyint(2) NOT NULL,
  bmonth varchar(50) NOT NULL,
  byear varchar(4) NOT NULL,
  address2 text NOT NULL,
  phone2 text NOT NULL,
  notes text NOT NULL,
  created datetime default NULL,
  modified datetime default NULL,
  deprecated datetime default NULL,
    password varchar(256) default NULL,
  login date default NULL,
  role varchar(256) default NULL,
  PRIMARY KEY (id, deprecated)
) DEFAULT CHARSET=utf8;

CREATE TABLE group_list (
  `domain_id` int(9) unsigned NOT NULL default '0',
  `group_id` int(9) unsigned NOT NULL auto_increment,
  `group_parent_id` int(9) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deprecated` datetime default NULL,
  `group_name` varchar(255) NOT NULL default '',
  `group_header` mediumtext NOT NULL,
  `group_footer` mediumtext NOT NULL,
  PRIMARY KEY  (`group_id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE address_in_groups (
  `domain_id` int(9) unsigned NOT NULL default '0',
  `id` int(9) unsigned NOT NULL default '0',
  `group_id` int(9) unsigned NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deprecated` datetime default NULL,
  PRIMARY KEY  (`group_id`,`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE month_lookup (
  `bmonth` varchar(50) NOT NULL default '',
  `bmonth_short` char(3) NOT NULL default '',
  `bmonth_num` int(2) unsigned NOT NULL default '0'
) DEFAULT CHARSET=utf8;

INSERT INTO `month_lookup` VALUES ('', '', 0);
INSERT INTO `month_lookup` VALUES ('January', 'Jan', 1);
INSERT INTO `month_lookup` VALUES ('February', 'Feb', 2);
INSERT INTO `month_lookup` VALUES ('March', 'Mar', 3);
INSERT INTO `month_lookup` VALUES ('April', 'Apr', 4);
INSERT INTO `month_lookup` VALUES ('May', 'May', 5);
INSERT INTO `month_lookup` VALUES ('June', 'Jun', 6);
INSERT INTO `month_lookup` VALUES ('July', 'Jul', 7);
INSERT INTO `month_lookup` VALUES ('August', 'Aug', 8);
INSERT INTO `month_lookup` VALUES ('September', 'Sep', 9);
INSERT INTO `month_lookup` VALUES ('October', 'Oct', 10);
INSERT INTO `month_lookup` VALUES ('November', 'Nov', 11);
INSERT INTO `month_lookup` VALUES ('December', 'Dec', 12);

CREATE TABLE user_prefs (
  `domain_id` int(9) unsigned NOT NULL default '0',
  `id` int(9) unsigned NOT NULL,
  `pref_key` varchar(255) NOT NULL default '',
  `pref_value` varchar(255) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deprecated` datetime default NULL,
  PRIMARY KEY  (`id`,`pref_key`),
  KEY `fk_id` (`id`)
) DEFAULT CHARSET=utf8;

CREATE VIEW vw_address AS select * from addressbook where isnull(deprecated);

CREATE VIEW vw_address_deleted AS
select * from addressbook
where (id,deprecated) in (select max(id), deprecated from addressbook 
 where deprecated > 0 group by id)
  and (id) not in (select id from addressbook 
 where deprecated is null
group by id)
order by deprecated desc;
