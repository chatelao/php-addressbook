<?php

function saveGroup($group_name, $group_header = "", $group_footer = "") {

  global $domain_id, $table_groups;
  
  $sql = "INSERT INTO $table_groups (domain_id,    group_name,   group_header,    group_footer) 
                             VALUES ('$domain_id', '$group_name','$group_header', '$group_footer')";
  $result = mysql_query($sql);

}

class Group {

    function __construct($data) {
    	$this->group = $data;
    }

}
?>