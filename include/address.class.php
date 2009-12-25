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

class Addresses {
	  	
    private $result;

    function __construct($searchstring) {
    	
	    global $base_from_where, $table;

     	$sql = "SELECT DISTINCT $table.* FROM $base_from_where";
        
      if ($searchstring) {
        
          $searchwords = split(" ", $searchstring);
        
          foreach($searchwords as $searchword) {
          	$sql .= "AND (   lastname  LIKE '%$searchword%' 
                          OR firstname LIKE '%$searchword%' 
                          OR company   LIKE '%$searchword%' 
                          OR address   LIKE '%$searchword%' 
                          OR home      LIKE '%$searchword%'
                          OR mobile    LIKE '%$searchword%'
                          OR work      LIKE '%$searchword%'
                          OR email     LIKE '%$searchword%'
                          OR email2    LIKE '%$searchword%'
                          OR address2  LIKE '%$searchword%' 
                          OR notes     LIKE '%$searchword%' 
                          )";
          }          
        }
        
        if(true) {
            $sql .= "ORDER BY lastname, firstname ASC";
        } else {
          	$sql .= "ORDER BY firstname, lastname ASC";
        }
      	$this->result = mysql_query($sql);
    }
    
    public function nextAddress() {
    	
    	$myrow = mysql_fetch_array($this->result);
    	if($myrow) {
		      return new Address($myrow);
		  } else {
		      return false;
		  }		  
    }

    public function getResults() {
    	return $this->result;
    }
}
?>