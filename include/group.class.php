<?php

function saveGroup($group_name, $group_header = "", $group_footer = "") {

  global $domain_id, $table_groups, $db_access;

  $sql = "INSERT INTO $table_groups (domain_id,    group_name,   group_header,    group_footer)
                             VALUES (?, ?, ?, ?)";
  $result = $db_access->execute($sql, [$domain_id, $group_name, $group_header, $group_footer]);

}

class Group {

    function __construct($data) {
	$this->group = $data;
    }

}
?>
