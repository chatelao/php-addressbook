<?php
require_once('dbconnect.php');

class Address {
	
    private $address;

    function __construct($data) {
    	$this->address = $data;
    }

    // addition by rehan@itlinkonline.com
    public function setPhones($query) {

        $result = mysql_query($query);
        while($phone = mysql_fetch_array($result)) {
            if($phone['primary_number']){
                $this->address['phone']['primary'] = $phone['phone_number'];
            }else{
                $this->address['phone'][] = $phone['phone_number'];
            }
        }
    }

    public function setEmails($query) {

        $result = mysql_query($query);
        $resultnumber = mysql_numrows($result);
        while($email = mysql_fetch_array($result)) {
            if($email['primary_email']){
                $this->address['email']['primary'] = $email['email_address'];
            }else{
                $this->address['email'][] = $email['email_address'];
            }
        }

    }

    public function setAddresses($query) {
        
        $result = mysql_query($query);
        while($address = mysql_fetch_array($result)) {
            if($address['primary_address']){
                $this->address['address']['primary'] = $address['postal_address'];
            }else{
                $this->address['address'][] = $address['postal_address'];
            }
        }
    }
    // end addition by rehan@itlinkonline.com

    public function getData() {
        return $this->address;
    }
    
    public function getEMails() {
    	
      $result = array();
    	// addition by rehan@itlinkonline.com
        for($i = 0; $i < count($this->address['email']); $i++) {
            $result[] = $this->address['email'][$i];
        }
        // end addition by rehan@itlinkonline.com
    	return $result;
    }
    
    // addition by rehan@itlinkonline.com
    public function primaryEmail(){

        return $this->address['email']['primary'];
    }
	// addition by rehan@itlinkonline.com

    public function firstEMail() {
        // addition by rehan@itlinkonline.com
        $email = $this->primaryEmail();
        if(!isset($email)){
            $emails = $this->getEMails();
            $email = (count($emails) > 0 ? $emails[0] : "");
        }
        return $email;
		// end addition by rehan@itlinkonline.com
    }
    
    public function getPhones() {
    	
      $phones = array();
        // addition by rehan@itlinkonline.com
        for($i = 0; $i < count($this->address['phone']); $i++) {
            $phones[] = $this->address['phone'][$i];
        }
        // end addition by rehan@itlinkonline.com
   	  return $phones;
   	}
    	
	// addition by rehan@itlinkonline.com
    public function primaryPhone(){
    
        return $this->address['phone']['primary'];
    }
	// end addition by rehan@itlinkonline.com

    public function firstPhone() {
		// addition by rehan@itlinkonline.com
        $phone = $this->primaryPhone();
        if(!isset($phone)){
            $phones = $this->getPhones();
            $phone = (count($phones) > 0 ? $phones[0] : "");
        }
        return $phone;
		// end addition by rehan@itlinkonline.com
    }

    public function shortPhone() {
    	
		  return str_replace("'", "", 
                         str_replace('/', "", 
                         str_replace(" ", "", 
                         str_replace(".", "", $this->firstPhone()))));
    }

    // addition by rehan@itlinkonline.com
    public function getAddress() {
        $address = array();
        for($i = 0; $i < count($this->address['address']); $i++) {
            $address[] = $this->address['address'][$i];
        }
        return $address;
    }
    
    public function primaryAddress() {

        return $this->address['address']['primary'];
    }
    
    public function firstAddress() {

        $address = $this->primaryAddress();
        if(!isset($address)){
            $addresses = $this->getAddress();
            $address = (count($addresses) > 0 ? $addresses[0] : "");
        }
        return $address;
    }

    // end addition by rehan@itlinkonline.com
}
?>