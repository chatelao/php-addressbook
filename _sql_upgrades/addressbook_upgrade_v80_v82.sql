
ALTER TABLE `addressbook` ADD `middlename` varchar(255) default NULL AFTER `firstname`;

ALTER TABLE `users` ADD `created`    DATETIME NULL after `trials`;
ALTER TABLE `users` ADD `modified`   DATETIME NULL after `created` ;
ALTER TABLE `users` ADD `deprecated` DATETIME NULL after `modified` ;
UPDATE `users` set created = now(), modified= now();
UPDATE `users` set created = now(), modified= now();