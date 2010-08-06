<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
<?php
//
// Read and execute all test files
//
if ($handle = opendir('.')) {

  // This is the correct way to loop over the directory.
  while (false !== ($file = readdir($handle))) {
      if(is_file($file) && $file != "index.php") {
      	echo "<h2>".$file."</h2>";
      	$tests = array();
      	include $file;
      };
  }

  closedir($handle);

}
?>