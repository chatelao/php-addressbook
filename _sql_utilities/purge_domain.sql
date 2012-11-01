
--
-- 0. BACKUP YOUR DATABASE FIRST
-- 1. Replace 0 by your domain_id in this file
-- 2. View the number of rows affected.
--
select 'Nr of total ids',        count(*) from addr_addressbook where domain_id = 0
union
select 'Nr of active ids',       count(*) from addr_addressbook where domain_id = 0 and deprecated is null
union
select 'Nr of purgable records', count(*) from addr_addressbook where domain_id = 0 and deprecated is not null

--
-- 3. Execute the deletion if you are REALLY sure 
--
delete 
  from addr_addressbook 
 where deprecated is not null 
   and deprecated > 0
   and domain_id = 0;
