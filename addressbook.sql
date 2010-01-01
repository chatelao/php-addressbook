-- phpMyAdmin SQL Dump
-- version 3.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 29, 2009 at 03:46 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `addressbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL auto_increment,
  `address_type_id` int(11) NOT NULL default '0',
  `addressbook_id` int(11) NOT NULL default '0',
  `postal_address` blob,
  `primary_address` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `addressbook`
--

CREATE TABLE `addressbook` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `homepage` text NOT NULL,
  `bday` tinyint(2) NOT NULL,
  `bmonth` varchar(50) NOT NULL,
  `byear` varchar(4) NOT NULL,
  `notes` text NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `password` varchar(256) default NULL,
  `login` date default NULL,
  `role` varchar(256) default NULL,
  `primary_phone_id` int(11) default NULL,
  `primary_email_id` int(11) default NULL,
  `primary_address_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `address_in_groups`
--

CREATE TABLE `address_in_groups` (
  `id` int(9) unsigned NOT NULL default '0',
  `group_id` int(9) unsigned NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`group_id`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `address_type`
--

CREATE TABLE `address_type` (
  `address_type_id` int(11) NOT NULL auto_increment,
  `address_type` varchar(20) NOT NULL,
  PRIMARY KEY  (`address_type_id`),
  UNIQUE KEY `address_type` (`address_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `email_id` int(11) NOT NULL auto_increment,
  `email_type_id` int(11) NOT NULL default '0',
  `addressbook_id` int(11) NOT NULL default '0',
  `email_address` varchar(255) default NULL,
  `primary_email` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_type`
--

CREATE TABLE `email_type` (
  `email_type_id` int(11) NOT NULL auto_increment,
  `email_type` varchar(20) NOT NULL,
  PRIMARY KEY  (`email_type_id`),
  UNIQUE KEY `email_type` (`email_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_list`
--

CREATE TABLE `group_list` (
  `group_id` int(9) unsigned NOT NULL auto_increment,
  `group_parent_id` int(9) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `group_name` varchar(255) NOT NULL default '',
  `group_header` mediumtext NOT NULL,
  `group_footer` mediumtext NOT NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `group_list`
--

INSERT INTO `group_list` (`group_id`, `group_parent_id`, `created`, `modified`, `group_name`, `group_header`, `group_footer`) VALUES
(2, NULL, NULL, NULL, 'Suppliers', '', ''),
(3, NULL, NULL, NULL, 'Manufacturers', '', 'large scale manufacturers which sell their products'),
(4, NULL, NULL, NULL, 'Clinics', '', 'doctors and small scale manufacturers for clinical use only.'),
(5, NULL, NULL, NULL, 'Owners', '', ''),
(6, NULL, NULL, NULL, 'Customers', '', ''),
(7, NULL, NULL, NULL, 'Wholeselers', '', ''),
(8, NULL, NULL, NULL, 'Importers', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `month_lookup`
--

CREATE TABLE `month_lookup` (
  `bmonth` varchar(50) NOT NULL default '',
  `bmonth_short` char(3) NOT NULL default '',
  `bmonth_num` int(2) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `month_lookup`
--

INSERT INTO `month_lookup` (`bmonth`, `bmonth_short`, `bmonth_num`) VALUES
('', '', 0),
('January', 'Jan', 1),
('February', 'Feb', 2),
('March', 'Mar', 3),
('April', 'Apr', 4),
('May', 'May', 5),
('June', 'Jun', 6),
('July', 'Jul', 7),
('August', 'Aug', 8),
('September', 'Sep', 9),
('October', 'Oct', 10),
('November', 'Nov', 11),
('December', 'Dec', 12);

-- --------------------------------------------------------

--
-- Table structure for table `phone`
--

CREATE TABLE `phone` (
  `phone_id` int(11) NOT NULL auto_increment,
  `phone_type_id` int(11) NOT NULL default '0',
  `addressbook_id` int(11) NOT NULL default '0',
  `phone_number` varchar(255) default NULL,
  `primary_number` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`phone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=242 ;

-- --------------------------------------------------------

--
-- Table structure for table `phone_type`
--

CREATE TABLE `phone_type` (
  `phone_type_id` int(11) NOT NULL auto_increment,
  `phone_type` varchar(20) default 'null',
  PRIMARY KEY  (`phone_type_id`),
  UNIQUE KEY `phone_type` (`phone_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_prefs`
--

CREATE TABLE `user_prefs` (
  `id` int(9) unsigned NOT NULL,
  `pref_key` varchar(255) NOT NULL default '',
  `pref_value` varchar(255) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`,`pref_key`),
  KEY `fk_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
