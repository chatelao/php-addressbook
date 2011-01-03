<?php
class ImportDel {

  protected $ab = array();
  protected $data;
  protected $row_offset = 0;
  protected $col_offset = 0;
  
  function convertToAddresses() {
  	
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
      
      // $mapping = "phpaddr";
      // $mapping = "outlook";
      $mapping = "nokia";
      include "import.csv.map-".$mapping.".php";
      
      $this->ab[] = $addr;
    }
  }

  function getResult() {
  	return $this->ab;
  }
}
?>