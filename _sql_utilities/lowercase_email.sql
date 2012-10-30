
--
-- 0. BACKUP YOUR DATABASE FIRST
-- 1. Replace 0 by your domain_id in this file
-- 2. View the number of rows affected.
--
select * 
  from addr_addressbook 
where domain_id = 0;
--
-- 3. Execute the deletion if you are REALLY sure 
--
update addr_addressbook 
  set email  = lower(email)
    , email2 = lower(email2)
    , email3 = lower(email3)
where domain_id = 0;
