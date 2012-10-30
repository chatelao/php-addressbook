--
-- Convert all table to transactional.
--
alter table addressbook       type=innodb;
alter table address_in_groups type=innodb;
alter table group_list        type=innodb;
alter table month_lookup      type=innodb;

--
-- Add foreign keys
--
ALTER TABLE address_in_groups ADD FOREIGN KEY addr_of_group (domain_id, group_id) 
                                   REFERENCES group_list    (domain_id, group_id);
ALTER TABLE address_in_groups ADD FOREIGN KEY addr_of_group (domain_id, id) 
                                   REFERENCES addressbook   (domain_id, id);
