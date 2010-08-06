<?php

class ImportCsv {

function __construct( $file_lines
                    , $delims = array(";", ",", "\t")
                    , $quotes = array('"', "'")
                    ) {
	
  function maxChar($chars, $testString) {
  	
  	$max_count = 0;		
    $the_char  = (count($chars) > 0 ? $chars[0] : " ");
    foreach($chars as $char) {
    	if(substr_count($testString, $char) > $max_count) {
    		$the_char = $char;
    	}
    }
    
    return $the_char;
  }

  $first_line = $file_lines[0];

  //
  // Detect the most probable delimiter.
  //
  $delim = maxChar($delims, $first_line);
  $quote = maxChar($quotes, $first_line);
  
  //
  // Detect if a quote is probable and remove the first + last
  //
  if(   substr($first_line,1,1) == substr($first_line,-1,1) 
     && substr($first_line,1,1) == $quote
     && substr_count($quote) > 1.5*substr_count($delim)) {
  	// $quote = $quote;
  } else {
  	$quote = "";	
  }
  
  function explodeWithQuotes($quote, $delimiter, $string) {
  	
  	// If has quotes, remove the first and last one
  	if($quote != "") {
  		$string = substr(substr($string, 1),0,-1);		
  	}
  	
  	// Explode using quotes and strings
  	return(explode($quote.$delimiter.$quote, $string));
  }
  
  
  //
  // Detect if a header line is probable
  //
  /*
  $first_line_fields = explodeWithQuotes($quote, $delim, $first_line);
  
  echo "<pre>";
  print_r($first_line_fields);
  */

  //
  // Detect if a header line is probable
  //
  $first_line_fields = explodeWithQuotes($quote, $delim, $first_line);  
  $cnt_uid_1st = count(array_unique($first_line_fields));
  $cnt_uid_2nd = count(array_unique(explodeWithQuotes($quote, $delim, $file_lines[1])));
  $cnt_uid_3rd = count(array_unique(explodeWithQuotes($quote, $delim, $file_lines[2])));  
  $may_have_header =   $cnt_uid_1st > $cnt_uid_2nd 
                    && $cnt_uid_1st > $cnt_uid_3rd;
                    
  // or see if no col starts with a number in first row, but some in 2nd
  // or see if all cols starts with a number in first row, but not all in 2nd
  
  
  //
  // Find the row with most fields filled
  //
  $count     = 0;
  $max_urows = 0;
  $max_rowid = 0;
  foreach($file_lines as $file_line) {
  	$line_fields = explodeWithQuotes($quote, $delim, $file_line);
 	  if(   ($count > 0  || ! $may_have_header)
 	     && $max_urows < count(array_unique($line_fields))
 	    ) {
 	  	$max_urows = count(array_unique($line_fields));
 	  	$max_rowid = $count;
 	  }
  	$count++;
  }
  $sample_fields = explodeWithQuotes($quote, $delim, $file_lines[$max_rowid]);


  //
  // Add samples for all other fields
  //
  $count     = 0;
  foreach($file_lines as $file_line) {
  	$line_fields = explodeWithQuotes($quote, $delim, $file_line);  	
 	  if($count > 0  || ! $may_have_header) {
 	  	for($i = 0; $i < min(count($sample_fields), count($line_fields)); $i++) {
 	  		if(strlen($sample_fields[$i]) == 0) {
 	  			$sample_fields[$i] = $line_fields[$i];
 	  		}
 	  	}
 	  }
  	$count++;
  }
  
  $count = 0;
  echo "<table>";
  for($i = 0; $i < count($first_line_fields); $i++) {
   	echo "<tr>";
   	echo "<td>".$first_line_fields[$i]."</td>";
   	echo "<td>".$sample_fields[$i]."</td>";
   	
   	$target_fields = array( "firstname"
   	                      , "lastname"
   	                      , "address"
   	                      , "address:pobox"
   	                      , "address:street"
   	                      , "address:zip"
   	                      , "address:city"
   	                      , "address:state"
   	                      , "address:county"
   	                      , "address2"
   	                      , "home"
   	                      , "business"
   	                      , "mobile"
   	                      , "fax"
   	                      , "phone2"
   	                      , "email"
   	                      , "email2" );
   	echo "<td><select><option default></option>\n<option>";
   	echo implode("</option>\n<option>", $target_fields);
   	echo "</option>\n</td></tr>\n";
  }
  echo "</table>";
  
  echo "Number of lines: $count";
  echo "</pre>";
}
}
?>