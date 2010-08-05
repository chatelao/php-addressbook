<?php

interface Context {
	
  public function getDb();  
  public function getDomain();  
  public function getUserName();  
  public function isReadOnly();
  
}
?>