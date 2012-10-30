select * from address_in_groups 
where id not in (select id from `addressbook`)
    or group_id not in (select group_id from group_list)