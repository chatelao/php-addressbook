<?php

interface Addresses {
	
  __construct($context);
  
  public function getAddressById($id);  
  public function searchAddress($search); 
  public function getAddressByAlphabet($letter);  
  public function getAddressByQuery($query);
  
}
?>