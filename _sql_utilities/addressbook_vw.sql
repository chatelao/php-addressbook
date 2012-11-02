--
-- Some (optional) views to select the current addresses.
--
CREATE VIEW vw_address AS select * from addressbook where isnull(deprecated);

--
-- Show all deleted fields
-- * May be used to recover "lost" records
--
CREATE VIEW vw_address_deleted AS
select * from addressbook
where (id,deprecated) in (select max(id), deprecated from addressbook 
 where deprecated > 0 group by id)
  and (id) not in (select id from addressbook 
 where deprecated is null
group by id)
order by deprecated desc;


--
-- Select records having very similar names in two domains
-- * May be used to merge new fields from imports in.
--
CREATE VIEW vw_address_match AS
SELECT dst.id AS dst_id
     , dst.firstname AS dst_first
     , dst.lastname AS dst_last
     , dst.domain_id AS dst_domain
     , src.id AS src_id,src.firstname AS src_first
     , src.lastname AS src_last
     , src.domain_id AS src_domain 
  FROM (vw_address dst join vw_address src) 
 WHERE (    (   (concat(' ',lcase(replace(replace(src.lastname,'-',' '),',',' ')),' ') like concat('% ',lcase(replace(replace(dst.lastname,'-',' '),',',' ')),' %')) 
             or (concat(' ',lcase(replace(replace(dst.lastname,'-',' '),',',' ')),' ') like concat('% ',lcase(replace(replace(src.lastname,'-',' '),',',' ')),' %')) 
             or (concat(' ',lcase(replace(replace(dst.lastname,'-',' '),',',' ')),' ') like concat('% ',lcase(replace(replace(src.firstname,'-',' '),',',' ')),' %'))) 
        and (src.lastname <> '') and (dst.lastname <> '') 
        and (   (concat(' ',lcase(replace(replace(src.firstname,'-',' '),',',' ')),' ') like concat('% ',lcase(replace(replace(dst.firstname,'-',' '),',',' ')),' %')) 
             or (concat(' ',lcase(replace(replace(dst.firstname,'-',' '),',',' ')),' ') like concat('% ',lcase(replace(replace(src.firstname,'-',' '),',',' ')),' %'))
             or (concat(' ',lcase(replace(replace(dst.firstname,'-',' '),',',' ')),' ') like concat('% ',lcase(replace(replace(src.lastname,'-',' '),',',' ')),' %')))
        and (src.firstname <> '') 
        and (dst.firstname <> '') 
        and (src.id <> dst.id)
       );

--
-- Select records having very similar names in two domains
-- * May be used to merge new fields from imports in.
--
CREATE VIEW vw_address_restore AS 
SELECT max(deprecated) AS deprecated
     , id
     , firstname
     , lastname
     , domain_id
  FROM vw_address_deleted 
GROUP BY id,domain_id order by domain_id,id;
