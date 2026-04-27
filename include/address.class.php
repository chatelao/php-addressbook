<?php

require_once "translations.inc.php";
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

function trimAll($r) {
  $res = array();
  foreach($r as $key => $val) {
  	$res[$key] = trim($val);
  }
  return $res;
}   

function echoIfSet($addr_array, $key) {
	echo getIfSetFromAddr($addr_array, $key);
}


function deleteAddresses($part_sql) {

  global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups, $db_access;

  $sql = "SELECT * FROM $base_from_where AND ".$part_sql;
  $result = $db_access->query($sql);
  $resultsnumber = $db_access->numRows($result);

  $is_valid = $resultsnumber > 0; 

  if($is_valid) {
  	if($keep_history) {
  	  $sql = "UPDATE $table
  	          SET deprecated = now()
	          WHERE deprecated is null AND ".$part_sql." AND domain_id = ?";
	  $db_access->execute($sql, [$domain_id]);
  	  $sql = "UPDATE $table_grp_adr
  	          SET deprecated = now()
	          WHERE deprecated is null AND ".$part_sql." AND domain_id = ?";
	  $db_access->execute($sql, [$domain_id]);
  	} else {
	  $sql = "DELETE FROM $table_grp_adr WHERE ".$part_sql." AND domain_id = ?";
	  $db_access->execute($sql, [$domain_id]);
	  $sql = "DELETE FROM $table         WHERE ".$part_sql." AND domain_id = ?";
	  $db_access->execute($sql, [$domain_id]);
    }
  }

  return $is_valid;
}

function saveAddress($addr_array, $group_name = "") {

	  global $domain_id, $table, $table_grp_adr, $table_groups, $month_lookup, $base_from_where, $db_access;

    $params = [$domain_id];
    if(isset($addr_array['id'])) {
	$set_id  = "?";
      $params[] = $addr_array['id'];
    	$src_tbl = $month_lookup." WHERE bmonth_num = 1";
    } else {
    	$set_id  = "ifnull(max(id),0)+1"; // '0' is a bad ID
    	$src_tbl = $table;
    }

    $fields = ['firstname', 'middlename', 'lastname', 'nickname', 'company', 'title', 'address', 'home', 'mobile', 'work', 'fax', 'email', 'email2', 'email3', 'homepage', 'aday', 'amonth', 'ayear', 'bday', 'bmonth', 'byear', 'address2', 'phone2', 'photo', 'notes'];
    foreach($fields as $field) {
      $params[] = getIfSetFromAddr($addr_array, $field);
    }

    $sql = "INSERT INTO $table ( domain_id, id, firstname, middlename, lastname, nickname, company, title, address, home, mobile, work, fax, email, email2, email3, homepage, aday, amonth, ayear, bday, bmonth, byear, address2, phone2, photo, notes, created, modified)
                        SELECT   ?                                         domain_id
                               , ".$set_id."                                       id
                               , ?  firstname
                               , ?  middlename
                               , ?  lastname
                               , ?  nickname
                               , ?  company
                               , ?  title
                               , ?  address
                               , ?  home
                               , ?  mobile
                               , ?  work
                               , ?  fax
                               , ?  email
                               , ?  email2
                               , ?  email3
                               , ?  homepage
                               , ?  aday
                               , ?  amonth
                               , ?  ayear
                               , ?  bday
                               , ?  bmonth
                               , ?  byear
                               , ?  address2
                               , ?  phone2
                               , ?  photo
                               , ?  notes
                               , now(), now()
                            FROM ".$src_tbl;
    $result = $db_access->execute($sql, $params);
    
    if($db_access->errno() > 0) {
      echo "MySQL: ".$db_access->errno().": ".$db_access->error();
    }

    $sql = "SELECT max(id) max_id from $table";
    $result = $db_access->query($sql);
    $rec = $db_access->fetchArray($result);
    $id = $rec['max_id'];

    if(!isset($addr_array['id']) && $group_name) {
	$sql = "INSERT INTO $table_grp_adr SELECT ? domain_id, ? id, group_id, now(), now(), NULL FROM $table_groups WHERE group_name = ?";
	$result = $db_access->execute($sql, [$domain_id, $id, $group_name]);
    }
    
    return $id;
}

function updateAddress($addr, $keep_photo = true) {

  global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups, $only_phone, $db_access;

	$addresses = Addresses::withID($addr['id']);
	$resultsnumber = $addresses->count();

	$homepage = str_replace('http://', '', $addr['homepage']);

	$is_valid = $resultsnumber > 0;

	if($is_valid)
	{
		if($keep_history) {
		
			// Get current photo, if "$keep_photo"
			if($keep_photo) {
		 	  $r = $addresses->nextAddress()->getData();
		 	  $addr['photo'] = $r['photo'];
			}

	    $sql = "UPDATE $table
	               SET deprecated = now()
		           WHERE deprecated is null
		             AND id	       = ?
		             AND domain_id = ?;";
	$result = $db_access->execute($sql, [$addr['id'], $domain_id]);
    	
		  saveAddress($addr);
		} else {
	    $sql = "UPDATE $table SET firstname = ?
	                            , lastname  = ?
	                            , middlename  = ?
	                            , nickname  = ?
	                            , company   = ?
	                            , title     = ?
	                            , address   = ?
	                            , home      = ?
	                            , mobile    = ?
	                            , work      = ?
	                            , fax       = ?
	                            , email     = ?
	                            , email2    = ?
	                            , email3    = ?
	                            , homepage  = ?
	                            , aday      = ?
	                            , amonth    = ?
	                            , ayear     = ?
	                            , bday      = ?
	                            , bmonth    = ?
	                            , byear     = ?
	                            , address2  = ?
	                            , phone2    = ?
	                            , notes     = ?
	    ".($keep_photo ? "" : ", photo     = ?")."
	                            , modified  = now()
		                        WHERE id        = ?
		                          AND domain_id = ?;";

      $params = [
        $addr['firstname'], $addr['lastname'], $addr['middlename'], $addr['nickname'],
        $addr['company'], $addr['title'], $addr['address'], $addr['home'],
        $addr['mobile'], $addr['work'], $addr['fax'], $addr['email'],
        $addr['email2'], $addr['email3'], $addr['homepage'], $addr['aday'],
        $addr['amonth'], $addr['ayear'], $addr['bday'], $addr['bmonth'],
        $addr['byear'], $addr['address2'], $addr['phone2'], $addr['notes']
      ];
      if(!$keep_photo) {
        $params[] = $addr['photo'];
      }
      $params[] = $addr['id'];
      $params[] = $domain_id;

		  $result = $db_access->execute($sql, $params);
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
    // Create a unified format for comparison an display.
    //
    public function unifyPhones( $phones
    	 	 	 	   , $prefix = ""
                               , $remove_prefix = false ) {
                              	
      global $intl_prefix_reg, $default_provider, $phone_delims;
                              	
      $unifons = array();
                              	
     // Remove all optical delimiters
     foreach($phones as $phone) {
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
        $unifons[] = $phone;  
      }
      return $unifons;

    }
    
	public function unifyPhone( $prefix = ""
                              , $remove_prefix = false ) {
       $phones = array();
       $phones[] = $this->firstPhone();
       
       $unifons = $this->unifyPhones($phones, $prefix, $remove_prefix);
       return $unifons[0];            
    }

    //
    // Show the phone number in the shortes readable format.
    //
    public function shortPhone() {
    	return $this->unifyPhone();
    }

    public function shortPhones() {
    	return $this->unifyPhones($this->getPhones());
    }

    public function getPhoto($only_phone = false) {
    	 $b64 = explode(";", $this->address["photo"]);
       if(count($b64) >= 3 && ! $only_phone) {
         $b64 = $b64[2];
         $b64 = explode(":", $b64);
         if(count($b64) >= 2) {
           $b64 = str_replace(" ", "", $b64[1]);
           return ($this->address["photo"] != "" ? '<img alt="Embedded Image" width=75 src="data:image/jpg;base64,'.$b64.'"/><br>' : "");
         }
       }
    }
}

class Addresses {

    private $result;

    function likePhone($row, $searchword) {
    	
	global $phone_delims, $db_access;
    	
    	$replace = $row;
	$like    = "'".$db_access->realEscapeString($searchword)."'";
     	foreach($phone_delims as $phone_delim) {
        $escaped_delim = $db_access->realEscapeString($phone_delim);
	  $replace = "replace(".$replace.", '".$escaped_delim."','')";
	  $like    = "replace(".$like.   ", '".$escaped_delim."','')";
     	}     	
     	return $replace." LIKE CONCAT('%',".$like.",'%')";    	
    }

    protected function loadBy($load_type, $searchstring, $alphabet = "") {

	    global $base_from_where, $table, $db_access;

     	$sql = "SELECT DISTINCT $table.* FROM $base_from_where";

      if($load_type == 'id') {

		    $sql .= " AND $table.id='".$db_access->realEscapeString($searchstring)."'";

      } elseif ($searchstring) {

          $searchwords = explode(" ", $searchstring);

          foreach($searchwords as $searchword) {
            $escaped_word = $db_access->realEscapeString($searchword);
		$sql .= " AND (   lastname   LIKE '%$escaped_word%'
                          OR middlename LIKE '%$escaped_word%'
                          OR firstname  LIKE '%$escaped_word%'
                          OR nickname   LIKE '%$escaped_word%'
                          OR company    LIKE '%$escaped_word%'
                          OR address    LIKE '%$escaped_word%'
                          OR ".$this->likePhone('home',   $searchword)."
                          OR ".$this->likePhone('work',   $searchword)."
                          OR ".$this->likePhone('mobile', $searchword)."
                          OR ".$this->likePhone('fax',    $searchword)."
                          OR email      LIKE '%$escaped_word%'
                          OR email2     LIKE '%$escaped_word%'
                          OR email3     LIKE '%$escaped_word%'
                          OR address2   LIKE '%$escaped_word%'
                          OR notes      LIKE '%$escaped_word%'
                          )";
          }
      }
      if($alphabet) {
        $escaped_alphabet = $db_access->realEscapeString($alphabet);
	$sql .= " AND (   lastname  LIKE  '$escaped_alphabet%'
                      OR middlename LIKE '$escaped_alphabet%'
                      OR nickname  LIKE  '$escaped_alphabet%'
                      OR firstname LIKE  '$escaped_alphabet%'
                      )";
      }

      if(true) {
          $sql .= " ORDER BY lastname, firstname ASC";
      } else {
		$sql .= " ORDER BY firstname, lastname ASC";
      }

      //* Paging
      $page = 1;
      $pagesize = 2200;
      if($pagesize > 0) {
          $sql .= " LIMIT ".(($page-1)*$pagesize).",".$pagesize;
      }
      //*/
      $this->result = $db_access->query($sql);
    }

    public static function withSearchString($searchstring, $alphabet = "") {
    	$instance = new self();
    	$instance->loadBy($searchstring, $alphabet);
    	return $instance;
    }

    public static function withID( $id ) {
    	$instance = new self();
    	$instance->loadBy('id', $id );
    	return $instance;
    }

    public function nextAddress() {

      global $db_access;
	$myrow = $db_access->fetchArray($this->result);
    	if($myrow) {
		      return new Address(trimAll($myrow));
		  } else {
		      return false;
		  }
    }

    public function getResults() {
    	return $this->result;
    }
    
    public function count() {
      global $db_access;
	return $db_access->numRows($this->getResults());
    }
}
?>