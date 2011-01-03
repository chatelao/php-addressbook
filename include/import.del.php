<?php
class ImportDel {

  protected $ab = array();
  protected $data;
  protected $row_offset = 0;
  protected $col_offset = 0;

  function convertToAddresses() {

  	global $del_format;

    $count = 0;
    foreach($this->data as $rec) {

    	$count++;
    	if($count <= $this->col_offset)
    	  continue;

      $keys = array_keys($rec);
      if(count($rec) > 0 && !is_int($keys[0])) {
        $val = array_values($rec);
        $rec = array_merge($rec, $val);
      }

      $off = $this->col_offset;

      if(in_array($del_format, array("outlook", "phpaddr", "nokia"))) {
        $mapping = $del_format;
      } else {
        $mapping = "phpaddr";
      }
      include "import.csv.map-".$mapping.".php";

      $this->ab[] = $addr;
    }
  }

  function getResult() {
  	return $this->ab;
  }
}
?>