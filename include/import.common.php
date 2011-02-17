<?php

  function MonthToName($number) {
  
    switch ($number) {
      case 1:
      case "01":
           return "January"; break;
      case 2:
      case "02":
           return "February"; break;
      case 3:
      case "03":
           return "March"; break;
      case 4:
      case "04":
           return "April"; break;
      case 5:
      case "05":
           return "May"; break;
      case 6:
      case "06":
           return "June"; break;
      case 7:
      case "07":
           return "July"; break;
      case 8:
      case "08":
           return "August"; break;
      case 9:
      case "09":
           return "September"; break;
      case "10":
           return "October"; break;
      case "11":
           return "November"; break;
      case "12":
           return "December"; break;
      default:
           return "";
    }
  }
  
  //
  // Pre-Convert to UTF-8:
  // * assumes file loaded into array "file_lines"
  //
  for($i = 0; $i < count($file_lines); $i++) {
  	  	
  	$line = $file_lines[$i];
  	
  	// use mb_detect_encoding()
    $encodings = array('UTF-8', 'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3',
      'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9',
      'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
      'WINDOWS-1252', 'WINDOWS-1251', 'BIG5', 'GB2312');

    // add "a" to avoid order misinterpretations
    $encoding = mb_detect_encoding($line."a",  $encodings);
    
    // Special detection of UTF-16
    if(strlen($line) >= 4) {
    	
    	// BOM detection
      if (substr($line, 0, 4) == "\0\0\xFE\xFF") $encoding =  'UTF-32BE';  // Big Endian
      if (substr($line, 0, 4) == "\xFF\xFE\0\0") $encoding =  'UTF-32LE';  // Little Endian
      if (substr($line, 0, 2) == "\xFE\xFF")     $encoding =  'UTF-16BE';  // Big Endian
      if (substr($line, 0, 2) == "\xFF\xFE")     $encoding =  'UTF-16LE';  // Little Endian
      if (substr($line, 0, 3) == "\xEF\xBB\xBF") $encoding =  'UTF-8';

      // Heuristic UTF-16 detection     
      if ((substr($line, 0, 4) & "\xFF\x00\xFF\x00") == "\0\0\0\0") $encoding = 'UTF-16BE';  // Big Endian
      if ((substr($line, 0, 4) & "\x00\xFF\x00\xFF") == "\0\0\0\0") $encoding = 'UTF-16LE';  // Little Endian
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
		
	} elseif(  substr_count($file_lines[0], ';')  > 5    // Is a CSV-File
	        || substr_count($file_lines[0], ',')  > 5 	        
	        || substr_count($file_lines[0], "\t") > 5) {
  	$import_type = "CSV";
		include_once ("import.csv.php");
		$icsv = new ImportCsv($file_lines);		
		$ab = $icsv->getResult();
		
	} elseif(   strtolower(pathinfo($file_name, PATHINFO_EXTENSION)) == "xls") {
		$import_type = "EXCEL";
		include_once ("import.xls.php");
		$ixls = new ImportXls($file_tmp_name);
		$ab = $ixls->getResult();
  			
	} else {
  	$import_type = "UNKNOWN";
  	$ab = array();
  }
  
?>