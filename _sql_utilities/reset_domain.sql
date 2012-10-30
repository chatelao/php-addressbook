
--
-- 0. BACKUP YOUR DATABASE FIRST
-- 1. Replace 189 by your domain_id in this file
-- 2. View the number of rows affected.
--
select 'Nr of addresses', count(*)         from addr_addressbook       where domain_id = 189
union
select 'Nr of address in groups', count(*) from addr_address_in_groups where domain_id = 189
union
select 'Nr of groups', count(*)            from addr_group_list        where domain_id = 189;

--
-- 3. Execute the deletion if you are REALLY sure 
--
delete from addr_addressbook       where domain_id = 189;
delete from addr_address_in_groups where domain_id = 189;
delete from addr_group_list        where domain_id = 189;
