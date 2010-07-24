<?php
//
// Read and execute all test files
//
if ($handle = opendir('.')) {

  // This is the correct way to loop over the directory.
  while (false !== ($file = readdir($handle))) {
      if(is_file($file) && $file != "index.php") {
      	include $file;
      };
  }

  closedir($handle);

}
?>