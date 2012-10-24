ALTER TABLE `user` ADD `created`    DATETIME NULL after `trials`;
ALTER TABLE `user` ADD `modified`   DATETIME NULL after `created` ;
ALTER TABLE `user` ADD `deprecated` DATETIME NULL after `modified` ;
UPDATE `user` set created = now(), modified= now();