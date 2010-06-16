<?php

function getIfSetFromAddr($addr_array, $key) {
	
	if(isset($addr_array[$key]) && isset($addr_array[$key])) {
	  return $addr_array[$key];
	} else {
		return "";
	}
}

function saveAddress($addr_array, $group_name = "") {
	
	  global $table, $table_grp_adr, $table_groups;

    $sql = "INSERT INTO $table ( firstname,    lastname,   company,    address,   home,   mobile,   work,   fax,   email,    email2,  homepage,   bday,  bmonth,   byear,    address2,    phone2,    notes,     created, modified)
                        VALUES ( '".getIfSetFromAddr($addr_array, 'firstname')."'
                               , '".getIfSetFromAddr($addr_array, 'lastname')."'
                               , '".getIfSetFromAddr($addr_array, 'company')."'
                               , '".getIfSetFromAddr($addr_array, 'address')."'
                               , '".getIfSetFromAddr($addr_array, 'home')."'
                               , '".getIfSetFromAddr($addr_array, 'mobile')."'
                               , '".getIfSetFromAddr($addr_array, 'work')."'
                               , '".getIfSetFromAddr($addr_array, 'fax')."'
                               , '".getIfSetFromAddr($addr_array, 'email')."'
                               , '".getIfSetFromAddr($addr_array, 'email2')."'
                               , '".getIfSetFromAddr($addr_array, 'homepage')."'
                               , '".getIfSetFromAddr($addr_array, 'bday')."'
                               , '".getIfSetFromAddr($addr_array, 'bmonth')."'
                               , '".getIfSetFromAddr($addr_array, 'byear')."'
                               , '".getIfSetFromAddr($addr_array, 'address2')."'
                               , '".getIfSetFromAddr($addr_array, 'phone2')."'
                               , '".getIfSetFromAddr($addr_array, 'notes')."'
                               , now(), now())";

    $result = mysql_query($sql);
    
    // $id = "SELECT LAST_INSERT_ID()"
    
    if($group_name) {
    	$sql = "INSERT INTO $table_grp_adr SELECT LAST_INSERT_ID() id, group_id, now(), now() FROM $table_groups WHERE group_name = '$group_name'";
    	$result = mysql_query($sql);
    }
}
    
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
    	
    public function hasPhone() {
    	
      return (count($this->getPhones()) > 0);
   	}

    public function firstPhone() {
    	
      $phones = $this->getPhones();
      return ($this->hasPhone() ? $phones[0] : "");
    }

    public function shortPhone() {
    	
		  return str_replace("'", "", 
                         str_replace('/', "", 
                         str_replace("-", "", 
                         str_replace(" ", "", 
                         str_replace(".", "", $this->firstPhone())))));
    }

}

class Addresses {
	  	
    private $result;

    function __construct($searchstring, $alphabet = "") {
    	
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
      if($alphabet) {
      	$sql .= "AND (   lastname  LIKE '$alphabet%'           	
                      OR firstname LIKE '$alphabet%' 
                      )";
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