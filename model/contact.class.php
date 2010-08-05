<?php

//
// Contact definition
//
interface Contact {
	
  public function getNames($index);
  public function getAllNames();
  public function getMaxAddress();

  public function getAddress($index);
  public function getAllAddresses($type = "");
  public function getMaxAddress();
  
  public function getEmail($index);
  public function getAllEmails($type = "");
  public function getMaxEmail();

  public function getPhone($index);
  public function getAllPhones($type = "");
  public function getMaxPhone();

  public function save();
}
?>