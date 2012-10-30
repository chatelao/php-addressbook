delete FROM `addressbook` 
WHERE lower(firstname) like '%test%'
   OR lower(lastname) like '%test%'
   OR lower(firstname) like '%sdf%'
   OR lower(lastname) like '%sdf%'
   OR lower(firstname) like '%miller%'
   OR lower(lastname) like '%miller%'
   OR lower(firstname) like '%müller%'
   OR lower(lastname) like '%müller%'
   OR (    (email  = '' or email  is null)
       AND (email2 = '' or email2 is null));
       
DELETE 
  FROM address_in_groups 
 WHERE id not in (select id from addressbook);
 
DELETE 
  FROM group_list 
 WHERE group_id not in (select group_id from address_in_groups) ;