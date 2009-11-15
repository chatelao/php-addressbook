<?php

class Address {
	
    private $address;

    function __construct($data) {
    	$this->address = $data;
    }

    public function getData() {
        return $this->address;
    }
    
    public function getEMails() {
    	
      $result = array();
    	if($this->address["email"]  != "")  $result[] = $this->address["email"];    	
    	if($this->address["email2"]  != "") $result[] = $this->address["email2"];
    	return $result;
    }
    
    public function firstEMail() {
    	  
      $emails = $this->getEMails();
      return (count($emails) > 0 ? $emails[0] : "");
    }
    
    //    
    // Phone order home->mobile->work
    //
    public function getPhones() {
    	
      $phones = array();
    	if($this->address["home"]   != "") $phones[] = $this->address["home"];
    	if($this->address["mobile"] != "") $phones[] = $this->address["mobile"];
    	if($this->address["work"]   != "") $phones[] = $this->address["work"];    	  
   	  return $phones;
   	}
    	
    public function firstPhone() {
    	
      $phones = $this->getPhones();
      return (count($phones) > 0 ? $phones[0] : "");
    }

    public function shortPhone() {
    	
		  return str_replace("'", "", 
                         str_replace('/', "", 
                         str_replace(" ", "", 
                         str_replace(".", "", $this->firstPhone()))));
    }
}
?>