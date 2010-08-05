<?php

//
// Group definition
//
interface Group {
	
  public function getName();
  public function setName();
  
  public function getContacts();
  
  public function addContact($contact);

}
?>