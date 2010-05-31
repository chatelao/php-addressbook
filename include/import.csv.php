<?php

//
// Begin CSV-Parser
//
$delims = array(";", ",", "\t");
$quotes = array('"', "'");

function maxChar($chars, $testString) {
	
	$the_char  = 0;
	$max_count = 0;
		
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
// Split all lines
//
$count = 0;
foreach($file_lines as $line) {

  $line_fields = explodeWithQuotes($quote, $delim, $line);
  $count++;
  if($count < 100) {
    print_r($line_fields);  	
  }
  
}
echo "Number of lines: $count";
echo "</pre>";
?>