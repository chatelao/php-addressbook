--
-- DB-Transformation to UTF-8
--
ALTER TABLE addressbook CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE group_list  CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
