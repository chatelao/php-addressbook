<?php

//
// "ADR" Type, delimiter ";" (7 fields)
//
// post office box; the extended address; the street                
// address; the locality (e.g., city); the region (e.g., state or
// province); the postal code; the country name
//
interface Address {
	
  public function getFormated();
  public function setFormated($formated_address);

  public function getStreet();
  public function getPostalCode(); 
  public function getCity();
  public function getExtAddress();
  public function getPostOfficeBox();
  public function getRegion();
  public function getCountry();

  public function setStreet($street);
  public function setPostalCode($zip); 
  public function setCity($city);
  public function setExtAddress($ext_addr);
  public function setPostOfficeBox($post_office_box);
  public function setRegion($region);
  public function setCountry($country);
  
}
?>