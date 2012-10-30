select * from 
(
SELECT `firstname`, `lastname`,count(*) cnt FROM `addressbook` group by `firstname`, `lastname`
) abc where cnt > 1