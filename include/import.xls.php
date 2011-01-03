<?php

require_once 'lib/excel_reader2.php';
require_once "import.del.php";

class ImportXls extends ImportDel {

  protected $ab = array();

  function ImportXls($filename) {
    
    //
    // Load the Excel data to array
    //
    $xls = new Spreadsheet_Excel_Reader($filename, 'utf-8');    
    $this->data = $xls->sheets[0]['cells'];

    //
    // Load the array to address records
    //
    $this->row_offset = 1; // Skip header
    $this->col_offset = 1; // Excel vs. CSV
    $this->convertToAddresses();
  }

  function getResult() {
  	return $this->ab;
  }  
}
?>