DELETE FROM `addr_addressbook` WHERE id IN (  SELECT id FROM addr_address_in_groups WHERE group_id IN (  SELECT group_id FROM addr_group_list WHERE group_name LIKE '@IMP%' ) );
DELETE FROM addr_address_in_groups WHERE group_id IN (  SELECT group_id FROM addr_group_list WHERE group_name LIKE '@IMP%' );
DELETE FROM addr_group_list WHERE group_name LIKE '@IMP%';