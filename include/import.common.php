<?php
 
  //
  // Pre-Convert to UTF-8:
  // * assumes file loaded into array "file_lines"
  //
  for($i = 0; $i < count($file_lines); $i++) {
  	  	
  	$line = $file_lines[$i];
    $encoding = mb_detect_encoding($line."a", 'ASCII, UTF-8, ISO-8859-1');
    // Special detection of UTF-16
    if(   strlen($line) >= 4
       && $line[1] != "\0"
       && $line[0] == "\0"
       && $line[1] != "\0"
       && $line[2] == "\0" 
       && $line[3] != "\0") {
      $encoding = 'UTF-16';
    }
    $file_lines[$i] = mb_convert_encoding($line, 'UTF-8', $encoding);
  }
  
  //
  // Load into memory
  //
  if(preg_match( "/^dn: /", $file_lines[0] ))       { // Is a LDIF-File
  	$import_type = "LDIF";
	  include_once ("import.ldif.php");
	} elseif(preg_match( "/^BEGIN:VCARD/", $file_lines[0] )) { // Is a vCard-File
  	$import_type = "VCARD";
		include_once ("import.vcard.php");
		$ivc = new ImportVCards($file_lines);
		$ab = $ivc->getResult();
	} elseif(substr_count($file_lines[0], ';') > 5 || substr_count($file_lines[0], ',') > 5) {
  	$import_type = "CSV";
		include_once ("include/import.csv.php");
		$icsv = new ImportCsv($file_lines);		
		$ab = array();
	} else {
  	$import_type = "UNKNOWN";
  }
  
?>