<?php

include "phone.intl_prefixes.php";
include "birthday.class.php";
      
function getIfSetFromAddr($addr_array, $key) {

	if(isset($addr_array[$key])) {	  
	  // $result = mysql_real_escape_string($addr_array[$key]);
	  $result = $addr_array[$key];
	} else {
		$result = "";
	}
	return $result;
}

function echoIfSet($addr_array, $key) {
	echo getIfSetFromAddr($addr_array, $key);
}


function deleteAddresses($part_sql) {

  global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups;

  $sql = "SELECT * FROM $base_from_where AND ".$part_sql;
  $result = mysql_query($sql);
  $resultsnumber = mysql_numrows($result);

  $is_valid = $resultsnumber > 0; 

  if($is_valid) {
  	if($keep_history) {
  	  $sql = "UPDATE $table
  	          SET deprecated = now()
  	          WHERE deprecated is null AND ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
  	  $sql = "UPDATE $table_grp_adr
  	          SET deprecated = now()
  	          WHERE deprecated is null AND ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
  	} else {
  	  $sql = "DELETE FROM $table_grp_adr WHERE ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
  	  $sql = "DELETE FROM $table         WHERE ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
    }
  }

  return $is_valid;
}

function saveAddress($addr_array, $group_name = "") {

	  global $domain_id, $table, $table_grp_adr, $table_groups, $month_lookup, $base_from_where;

    if(isset($addr_array['id'])) {
    	$set_id  = "'".$addr_array['id']."'";
    	$src_tbl = $month_lookup." WHERE bmonth_num = 1";
    } else {
    	$set_id  = "ifnull(max(id),0)+1"; // '0' is a bad ID
    	$src_tbl = $table;
    }

    $sql = "INSERT INTO $table ( domain_id, id, firstname, lastname, nickname, company, title, address, home, mobile, work, fax, email, email2, email3, homepage, aday, amonth, ayear, bday, bmonth, byear, address2, phone2, photo, notes, created, modified)
                        SELECT   $domain_id                                       domain_id
                               , ".$set_id."                                      id
                               , '".getIfSetFromAddr($addr_array, 'firstname')."' firstname
                               , '".getIfSetFromAddr($addr_array, 'lastname')."'  lastname
                               , '".getIfSetFromAddr($addr_array, 'nickname')."'  nickname
                               , '".getIfSetFromAddr($addr_array, 'company')."'   company
                               , '".getIfSetFromAddr($addr_array, 'title')."'     title
                               , '".getIfSetFromAddr($addr_array, 'address')."'   address
                               , '".getIfSetFromAddr($addr_array, 'home')."'      home
                               , '".getIfSetFromAddr($addr_array, 'mobile')."'    mobile
                               , '".getIfSetFromAddr($addr_array, 'work')."'      work
                               , '".getIfSetFromAddr($addr_array, 'fax')."'       fax
                               , '".getIfSetFromAddr($addr_array, 'email')."'     email
                               , '".getIfSetFromAddr($addr_array, 'email2')."'    email2
                               , '".getIfSetFromAddr($addr_array, 'email3')."'    email3
                               , '".getIfSetFromAddr($addr_array, 'homepage')."'  homepage
                               , '".getIfSetFromAddr($addr_array, 'aday')."'      aday
                               , '".getIfSetFromAddr($addr_array, 'amonth')."'    amonth
                               , '".getIfSetFromAddr($addr_array, 'ayear')."'     ayear
                               , '".getIfSetFromAddr($addr_array, 'bday')."'      bday
                               , '".getIfSetFromAddr($addr_array, 'bmonth')."'    bmonth
                               , '".getIfSetFromAddr($addr_array, 'byear')."'     byear
                               , '".getIfSetFromAddr($addr_array, 'address2')."'  address2
                               , '".getIfSetFromAddr($addr_array, 'phone2')."'    phone2
                               , '".getIfSetFromAddr($addr_array, 'photo')."'     photo
                               , '".getIfSetFromAddr($addr_array, 'notes')."'     notes
                               , now(), now()
                            FROM ".$src_tbl;
    $result = mysql_query($sql);

    $sql = "SELECT max(id) max_id from $table";
    $result = mysql_query($sql);
    $rec = mysql_fetch_array($result);
    $id = $rec['max_id'];

    if(!isset($addr_array['id']) && $group_name) {
    	$sql = "INSERT INTO $table_grp_adr SELECT $domain_id domain_id, $id id, group_id, now(), now(), NULL FROM $table_groups WHERE group_name = '$group_name'";
    	$result = mysql_query($sql);
    }
    
    return $id;
}

function updateAddress($addr) {

  global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups;

  $sql = "SELECT * FROM $base_from_where AND $table.id = '".$addr['id']."';";
  $result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	$homepage = str_replace('http://', '', $addr['homepage']);

	$is_valid = $resultsnumber > 0;

	if($is_valid)
	{
		if($keep_history) {
	    $sql = "UPDATE $table
	               SET deprecated = now()
		           WHERE deprecated is null
		             AND id       = '".$addr['id']."';";
    	$result = mysql_query($sql);
		  saveAddress($addr);
		} else {
	    $sql = "UPDATE $table SET firstname = '".$addr['firstname']."'
	                            , lastname  = '".$addr['lastname']."'
	                            , nickname  = '".$addr['nickname']."'
	                            , company   = '".$addr['company']."'
	                            , title     = '".$addr['title']."'
	                            , address   = '".$addr['address']."'
	                            , home      = '".$addr['home']."'
	                            , mobile    = '".$addr['mobile']."'
	                            , work      = '".$addr['work']."'
	                            , fax       = '".$addr['fax']."'
	                            , email     = '".$addr['email']."'
	                            , email2    = '".$addr['email2']."'
	                            , email3    = '".$addr['email3']."'
	                            , homepage  = '".$addr['homepage']."'
	                            , aday      = '".$addr['aday']."'
	                            , amonth    = '".$addr['amonth']."'
	                            , ayear     = '".$addr['ayear']."'
	                            , bday      = '".$addr['bday']."'
	                            , bmonth    = '".$addr['bmonth']."'
	                            , byear     = '".$addr['byear']."'
	                            , address2  = '".$addr['address2']."'
	                            , phone2    = '".$addr['phone2']."'
	                            , notes     = '".$addr['notes']."'
	                            , modified  = now()
		                        WHERE id        = '".$addr['id']."'
		                          AND domain_id = '$domain_id';";
		  $result = mysql_query($sql);
    }
		// header("Location: view?id=$id");
    }

	return $is_valid;
}

$phone_delims = array("'", '/', "-", " ", "(", ")", ".");

class Address {

    private $address; // mother of all data
    
    private $phones;
    private $emails;

    function __construct($data) {
    	$this->address = $data;
    	$this->phones = $this->getPhones();
    	$this->emails = $this->getEMails();
    }

    public function getData() {
        return $this->address;
    }

    public function getEMails() {

      $result = array();
    	if($this->address["email"]   != "") $result[] = $this->address["email"];
    	if($this->address["email2"]  != "") $result[] = $this->address["email2"];
    	if($this->address["email3"]  != "") $result[] = $this->address["email3"];
    	return $result;
    }

    public function firstEMail() {
      return (!empty($this->emails) ? $this->emails[0] : "");
    }

    public function getBirthday() {
    	return new Birthday($this->address, "b");
    }

    //
    // Phone order home->mobile->work->phone2
    //
    public function getPhones() {

      $phones = array();
    	if($this->address["home"]   != "") $phones[] = $this->address["home"];
    	if($this->address["mobile"] != "") $phones[] = $this->address["mobile"];
    	if($this->address["work"]   != "") $phones[] = $this->address["work"];
    	if($this->address["phone2"] != "") $phones[] = $this->address["phone2"];
   	  return $phones;
   	}

    public function hasPhone() {

      return !empty($this->phones);
   	}

    public function firstPhone() {
      return (!empty($this->phones) ? $this->phones[0] : "");
    }

    //
    // Create a unified format for comparision an display.
    //
    public function unifyPhone( $prefix = ""
                              , $remove_prefix = false ) {
                              	
      global $intl_prefix_reg, $default_provider, $phone_delims;
                              	
    	// Remove all optical delimiters
    	$phone = $this->firstPhone();
    	foreach($phone_delims as $phone_delim) {
    		$phone = str_replace($phone_delim, "", $phone);
    	}
                
    	if($prefix != "" || $remove_prefix = true) {
    		
    	  // Replace 00xxx => +xx
    	  $phone = preg_replace('/^00/', "+", $phone);
        
    	  // Replace 0 with $prefix (00 is already "+")
    	  if($prefix != "") {
    	    $phone = preg_replace('/^0/', $prefix, $phone);
    	  }
        
    	  // Replace xx (0) yy => xxyy
        $phone = preg_replace("/^(".$intl_prefix_reg.")0/", '${1}', $phone);   		
                
    	  // Replace +xx with 0
    	  if($remove_prefix) {
    	  	if(isset($default_provider)) {
    	  		$remove_prefixes = str_replace("+", "\+",$default_provider);
    	  	} else {
    	  		$remove_prefixes = $intl_prefix_reg;
    	  	}
    	  	$phone = preg_replace("/^(".$remove_prefixes.")/", "0", $phone);
        }
      }

    	return $phone;

    }

    //
    // Show the phone number in the shortes readable format.
    //
    public function shortPhone() {
    	return $this->unifyPhone();
    }

}

class Addresses {

    private $result;

    function likePhone($row, $searchword) {
    	
    	global $phone_delims;
    	
    	$replace = $row;
    	$like    = "'$searchword'";
     	foreach($phone_delims as $phone_delim) {
    	  $replace = "replace(".$replace.", '".mysql_real_escape_string($phone_delim)."','')"; 
    	  $like    = "replace(".$like.   ", '".mysql_real_escape_string($phone_delim)."','')"; 
     	}     	
     	return $replace." LIKE CONCAT('%',".$like.",'%')";    	
    }

    function __construct($searchstring, $alphabet = "") {

	    global $base_from_where, $table;

     	$sql = "SELECT DISTINCT $table.* FROM $base_from_where";

      if ($searchstring) {

          $searchwords = explode(" ", $searchstring);

          foreach($searchwords as $searchword) {
          	$sql .= "AND (   lastname  LIKE '%$searchword%'
                          OR firstname LIKE '%$searchword%'
                          OR nickname  LIKE '%$searchword%'
                          OR company   LIKE '%$searchword%'
                          OR address   LIKE '%$searchword%'
                          OR ".$this->likePhone('home',   $searchword)."
                          OR ".$this->likePhone('work',   $searchword)."
                          OR ".$this->likePhone('mobile', $searchword)."
                          OR ".$this->likePhone('fax',    $searchword)."
                          OR email     LIKE '%$searchword%'
                          OR email2    LIKE '%$searchword%'
                          OR email3    LIKE '%$searchword%'
                          OR address2  LIKE '%$searchword%'
                          OR notes     LIKE '%$searchword%'
                          )";
          }
      }
      if($alphabet) {
      	$sql .= "AND (   lastname  LIKE '$alphabet%'
                      OR nickname  LIKE '$alphabet%'
                      OR firstname LIKE '$alphabet%'
                      )";
      }

      if(true) {
          $sql .= "ORDER BY lastname, firstname ASC";
      } else {
        	$sql .= "ORDER BY firstname, lastname ASC";
      }
      
      //* Paging
      $page = 1;
      $pagesize = 2200;
      if($pagesize > 0) {
          $sql .= " LIMIT ".($page-1)*$pagesize.",".$pagesize;
      }
      //*/
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