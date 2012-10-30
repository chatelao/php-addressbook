--
-- Upgrade from 7.0.x to 8.0.x
--

--
-- Add user management table
--
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(9) unsigned NOT NULL DEFAULT '0',
  `username` char(128) NOT NULL,
  `md5_pass` char(128) NOT NULL,
  `password_hint` varchar(255) NOT NULL DEFAULT '',
  `sso_facebook_uid` varchar(255) DEFAULT NULL,
  `sso_google_uid` varchar(255) DEFAULT NULL,
  `sso_live_uid` varchar(255) DEFAULT NULL,
  `sso_yahoo_uid` varchar(255) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `address1` varchar(100) NOT NULL DEFAULT '',
  `address2` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(80) NOT NULL DEFAULT '',
  `state` varchar(20) NOT NULL DEFAULT '',
  `zip` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `master_code` char(128) NOT NULL,
  `confirmation_code` char(128) DEFAULT NULL,
  `pass_reset_code` char(128) DEFAULT NULL,
  `status` char(128) NOT NULL DEFAULT 'NEW' COMMENT 'New, Ready, Blocked',
  `trials` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) DEFAULT CHARSET=utf8;