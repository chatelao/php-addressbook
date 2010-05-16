<?php

function saveGroup($group_name, $group_header = "", $group_footer = "") {

  global $table_groups;
  
  $sql = "INSERT INTO $table_groups (group_name, group_header, group_footer) 
                             VALUES ('$group_name','$group_header','$group_footer')";
  $result = mysql_query($sql);

}

class Group {

    function __construct($data) {
    	$this->group = $data;
    }

}
?>