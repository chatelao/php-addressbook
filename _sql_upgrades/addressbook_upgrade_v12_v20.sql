ALTER TABLE addressbook ADD address2 text NOT NULL;
ALTER TABLE addressbook ADD phone2   text NOT NULL;

CREATE TABLE month_lookup (
  bmonth varchar(50) NOT NULL default '',
  bmonth_short char(3) NOT NULL default '',
  bmonth_num int(2) unsigned NOT NULL default '0'
);


INSERT INTO month_lookup VALUES ('', '', 0);
INSERT INTO month_lookup VALUES ('January', 'Jan', 1);
INSERT INTO month_lookup VALUES ('February', 'Feb', 2);
INSERT INTO month_lookup VALUES ('March', 'Mar', 3);
INSERT INTO month_lookup VALUES ('April', 'Apr', 4);
INSERT INTO month_lookup VALUES ('May', 'May', 5);
INSERT INTO month_lookup VALUES ('June', 'Jun', 6);
INSERT INTO month_lookup VALUES ('July', 'Jul', 7);
INSERT INTO month_lookup VALUES ('August', 'Aug', 8);
INSERT INTO month_lookup VALUES ('September', 'Sep', 9);
INSERT INTO month_lookup VALUES ('October', 'Oct', 10);
INSERT INTO month_lookup VALUES ('November', 'Nov', 11);
INSERT INTO month_lookup VALUES ('December', 'Dec', 12);