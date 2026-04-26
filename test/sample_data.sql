-- Add a sample contact
SET SQL_MODE='';
INSERT INTO `addressbook` (
    `domain_id`, `id`, `firstname`, `middlename`, `lastname`, `nickname`,
    `company`, `title`, `address`, `home`, `mobile`, `work`, `fax`,
    `email`, `email2`, `email3`, `im`, `im2`, `im3`, `homepage`,
    `bday`, `bmonth`, `byear`, `aday`, `amonth`, `ayear`,
    `address2`, `phone2`, `notes`, `created`, `modified`, `deprecated`
) VALUES (
    0, 1, 'John', 'Q.', 'Doe', 'JD',
    'ACME Corp', 'Engineer', '123 Main St\nAnytown, USA', '555-1212', '555-1313', '555-1414', '555-1515',
    'john.doe@example.com', 'jd@example.org', '', '', '', '', 'http://example.com/~jdoe',
    15, 'January', '1980', 1, 'January', '2010',
    'Secondary Address', '555-2222', 'Notes about John Doe', NOW(), NOW(), '0000-00-00 00:00:00'
);

-- Add another sample contact for birthday variety
INSERT INTO `addressbook` (
    `domain_id`, `id`, `firstname`, `middlename`, `lastname`, `nickname`,
    `company`, `title`, `address`, `home`, `mobile`, `work`, `fax`,
    `email`, `email2`, `email3`, `im`, `im2`, `im3`, `homepage`,
    `bday`, `bmonth`, `byear`, `aday`, `amonth`, `ayear`,
    `address2`, `phone2`, `notes`, `created`, `modified`, `deprecated`
) VALUES (
    0, 2, 'Jane', 'M.', 'Smith', 'JS',
    'Globex', 'Manager', '456 Elm St\nOthertown, USA', '555-3333', '555-4444', '', '',
    'jane.smith@example.com', '', '', '', '', '', '',
    20, 'February', '1985', 0, '', '',
    '', '', 'Notes about Jane', NOW(), NOW(), '0000-00-00 00:00:00'
);

-- Add a sample group
INSERT INTO `group_list` (
    `domain_id`, `group_id`, `group_name`, `group_header`, `group_footer`, `created`, `modified`, `deprecated`
) VALUES (
    0, 1, 'Test Group', 'Header for Test Group', 'Footer for Test Group', NOW(), NOW(), '0000-00-00 00:00:00'
);

-- Assign John Doe to Test Group
INSERT INTO `address_in_groups` (
    `domain_id`, `id`, `group_id`, `created`, `modified`, `deprecated`
) VALUES (
    0, 1, 1, NOW(), NOW(), '0000-00-00 00:00:00'
);
