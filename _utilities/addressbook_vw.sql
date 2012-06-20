--
-- Some (optional) views to select the current addresses.
--
CREATE VIEW vw_address AS select * from addressbook where isnull(deprecated);

CREATE VIEW vw_address_deleted AS
select * from addressbook
where (id,deprecated) in (select max(id), deprecated from addressbook 
 where deprecated > 0 group by id)
  and (id) not in (select id from addressbook 
 where deprecated is null
group by id)
order by deprecated desc;
