ALTER TABLE `user` ADD `created`    DATETIME NULL after `trials`;
ALTER TABLE `user` ADD `modified`   DATETIME NULL after `created` ;
ALTER TABLE `user` ADD `deprecated` DATETIME NULL after `modified` ;
UPDATE `user` set created = now(), modified= now();

RENAME TABLE `user` TO `users`;

ALTER TABLE `users` ADD `display_name` varchar(50) NOT NULL         AFTER `username`;
ALTER TABLE `users` ADD `activation_token` varchar(225) NOT NULL    AFTER `country`;
ALTER TABLE `users` ADD `last_activation_request` int(11) NOT NULL  AFTER `activation_token`;
ALTER TABLE `users` ADD `lost_password_request` tinyint(1) NOT NULL AFTER `last_activation_request`;
ALTER TABLE `users` ADD `active` tinyint(1) NOT NULL                AFTER `lost_password_request`;
ALTER TABLE `users` ADD `title` varchar(150) NOT NULL               AFTER `active`;
ALTER TABLE `users` ADD `sign_up_stamp` int(11) NOT NULL            AFTER `title`;
ALTER TABLE `users` ADD `last_sign_in_stamp` int(11) NOT NULL       AFTER `sign_up_stamp`;

UPDATE users SET active = 1;

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18;

INSERT INTO `pages` (`id`, `page`, `private`) VALUES
(1, 'account.php', 1),
(2, 'activate-account.php', 0),
(3, 'admin_configuration.php', 1),
(4, 'admin_page.php', 1),
(5, 'admin_pages.php', 1),
(6, 'admin_permission.php', 1),
(7, 'admin_permissions.php', 1),
(8, 'admin_user.php', 1),
(9, 'admin_users.php', 1),
(10, 'forgot-password.php', 0),
(11, 'index.php', 0),
(12, 'left-nav.php', 0),
(13, 'login.php', 0),
(14, 'logout.php', 1),
(15, 'register.php', 0),
(16, 'resend-activation.php', 0),
(17, 'user_settings.php', 1);

CREATE TABLE IF NOT EXISTS `permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

INSERT INTO `permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(1, 1, 1),
(2, 1, 14),
(3, 1, 17),
(4, 2, 1),
(5, 2, 3),
(6, 2, 4),
(7, 2, 5),
(8, 2, 6),
(9, 2, 7),
(10, 2, 8),
(11, 2, 9),
(12, 2, 14),
(13, 2, 17);

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'New User'),
(2, 'Administrator');

CREATE TABLE IF NOT EXISTS `user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
