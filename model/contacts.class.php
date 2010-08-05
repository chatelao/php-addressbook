<?php

interface Contacts {
	
  __construct($context);
  
  public function getContactById($id);  
  public function searchContact($search); 
  public function getContactByAlphabet($letter);  
  public function getContactByQuery($query);
  
  public function newContact();  
  public function getContact();  
  
}
?>