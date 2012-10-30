--
-- Table upgrade to UTF-8
--
ALTER TABLE addressbook       CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE group_list        CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE address_in_groups CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE month_lookup      CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
